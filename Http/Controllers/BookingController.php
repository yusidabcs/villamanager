<?php namespace Modules\Villamanager\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\User\Contracts\Authentication;
use Modules\Villamanager\Entities\Booking;
use Modules\Villamanager\Entities\Country;
use Modules\Villamanager\ICS;
use Modules\Villamanager\Repositories\DiscountRepository;
use Modules\Villamanager\Repositories\VillaRepository;
use Illuminate\Http\Request;
use Modules\Villamanager\Entities\Villa;
use Modules\Villamanager\Http\Requests\StoreBookingRequest;
use Modules\Villamanager\Repositories\BookingRepository;
use Paypal;
use Mail;
use Veritrans_Config;
use Veritrans_Snap;

class BookingController extends BasePublicController
{
    /**
     * @var PageRepository
     */
    private $villa;
    private $booking;
    private $discount;
    /**
     * @var Application
     */
    private $app;
    private $_apiContext;
    private $user;


    public function __construct(VillaRepository $villa,BookingRepository $booking, Application $app, DiscountRepository $discount, Authentication $user)
    {
        parent::__construct();
        $this->villa = $villa;
        $this->app = $app;
        $this->booking = $booking;
        $this->discount = $discount;
        $this->user = $user;

        if(setting('villamanager::paypal_sandbox') == 'true'){
            $this->_apiContext = PayPal::ApiContext(
                setting('villamanager::paypal_sandbox_client_id'),
                setting('villamanager::paypal_sandbox_secret'));

            $this->_apiContext->setConfig(array(
                'mode' => 'sandbox',
                'service.EndPoint' => 'https://api.sandbox.paypal.com',
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path('logs/paypal.log'),
                'log.LogLevel' => 'FINE'
            ));
        }else{

            $this->_apiContext = PayPal::ApiContext(
                setting('villamanager::paypal_client_id'),
                setting('villamanager::paypal_secret'));

            $this->_apiContext->setConfig(array(
                'mode' => 'live',
                'service.EndPoint' => 'https://api.paypal.com',
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path('logs/paypal.log'),
                'log.LogLevel' => 'FINE'
            ));

        }
        Veritrans_Config::$serverKey = setting('villamanager::midtrans_server_key');
        if(!setting('villamanager::midtrans_sandbox')){
            Veritrans_Config::$isProduction = true;
        }
        Veritrans_Config::$isSanitized = true;
        Veritrans_Config::$is3ds = true;
    }

    public function index(){

        if(!Sentinel::check()){
            return redirect()->route('users.login');
        }
        $bookings = $this->booking->findByUser($this->user->user()->id);

        return view('users.bookings',compact('bookings'));
    }

    public function show(Request $request, $id)
    {
        $start = date('Y-m-d H:i:s',strtotime($request->get('check_in').' 14:00:00'));
        $end = date('Y-m-d H:i:s',strtotime($request->get('check_out').' 14:00:00'));

        $villa = Villa::whereDoesntHave('bookings', function ($q) use ($start,$end){

            $q->whereRaw('(check_in between "'.$start.'" and "'.$end.'" 
                OR "'.$start.'" between  check_in  and  check_out  
                OR  check_out between "'.$start.'" and "'.$end.'" 
                OR "'.$end.'" between check_in  and check_out)');

        })->whereDoesntHave('disableDates',function ($q) use ($start,$end){
            $q->whereRaw('(date between "'.$start.'" and "'.$end.'" )');
        })
            ->where('id',$id)->first();

        if(!$villa)
        {
            return redirect()->back()
                ->withError('Villa have booked on this date range. Please try other date.');
        }

        $this->throw404IfNotFound($villa);

        $countries = Country::all();

        $template = 'bookings.index';

        return view($template, compact('villa','countries'));
    }

    public function confirmation(Request $request, $id)
    {
        $villa = $this->villa->find($id);
        $discount = \Modules\Villamanager\Entities\Discount::where('code',request()->get('discount_code'))->first();

        $this->throw404IfNotFound($villa);

        $template = 'bookings.confirmation';

        return view($template, compact('villa','discount'));
    }

    public function store(StoreBookingRequest $request,$id)
    {
        $booking = $this->booking->create($request->all());

        $this->discount->claimDiscountByCode();

        if($booking instanceof RedirectResponse){
            return $booking;
        }
        $booking = $this->booking->find($booking->id);

        Mail::send('emails.create-villa-booking', ['booking' => $booking], function ($m) use ($booking) {

            $m->to($booking->email, $booking->title.' '.$booking->first_name.' '.$booking->last_name)->subject(setting('core::site-name').' Booking Detail');
        });

        Mail::send('emails.create-villa-booking', ['booking' => $booking], function ($m) use ($booking) {

            $m->to(setting('core::email'), $booking->title.' '.$booking->first_name.' '.$booking->last_name)->subject(setting('core::site-name').' New Booking Detail');
        });

        return redirect()->route('villamanager.bookings.payment',$booking->booking_number)
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('villamanager::bookings.title.bookings')]));

    }

    public function payment($id)
    {
        $booking = $this->booking->findByBookingNumber($id);
        $villa = $booking->villa;
        $countries = Country::all();
        $template = 'bookings.payment';
        $snapToken = '';
        if($booking->payment_type == 2 && $booking->status == 0)
        {
            $snapToken = $this->payWithMidtrans($booking);
        }
        return view($template, compact('booking','villa','countries','snapToken'));


    }
   /* public function payment($id)
    {
        $booking = $this->booking->findByBookingNumber($id);
        $villa = $booking->villa;
        $countries = Country::all();
        $template = 'bookings.payment';

        if($booking->payment_type == 2)
        {
            $snapToken = $this->payWithMidtrans($booking);
            return $snapToken;
        }
        return 1;
        return view($template, compact('booking','villa','countries','snapToken'));


    }*/

    public function payWithMidtrans($booking)
    {
        $transaction_details = array(
            'order_id' => $booking->booking_number,
            'gross_amount' => currency($booking->total,'USD','IDR',false),
        );
// Optional
        $item1_details = array(
            'id' => $booking->villa->id,
            'price' => currency($booking->total,'USD','IDR',false),
            'quantity' => 1,
            'name' => "Booking For #".$booking->booking_number
        );

// Optional
        $item_details = array ($item1_details);

        $transaction = array(
            'transaction_details' => $transaction_details,
            'item_details' => $item_details,
        );
        return Veritrans_Snap::getSnapToken($transaction);
    }



    public function paywithpaypal($id)
    {
        $booking = $this->booking->findByBookingNumber($id);

        $this->throw404IfNotFound($booking);

        $item1 = PayPal::item();
        $item1->setName('Booking for '.$booking->villa->name)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku("1") // Similar to `item_number` in Classic API
            ->setPrice($booking->total);


        $itemList = PayPal::ItemList();
        $itemList->setItems(array($item1));


        $payer = PayPal::Payer();
        $payer->setPaymentMethod('paypal');

        $amount = PayPal::Amount();
        $amount->setCurrency('USD');
        $amount->setTotal($booking->total);

        $transaction = PayPal::Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription(setting('core::site-name') .' ~ '.'Payment for booking #'.$booking->booking_number);

        $redirectUrls = PayPal:: RedirectUrls();
        $redirectUrls->setReturnUrl(route('villamanager.bookings.paypalsuccess',$id));
        $redirectUrls->setCancelUrl(route('villamanager.bookings.paypalcancel',$id));

        $payment = PayPal::Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setRedirectUrls($redirectUrls);
        $payment->setTransactions(array($transaction));

        $response = $payment->create($this->_apiContext);
        $redirectUrl = $response->links[1]->href;

        return redirect()->to( $redirectUrl );

    }

    public function paypalsuccess(Request $request,$id)
    {
        $booking = $this->booking->findByBookingNumber($id);
        $id = $request->get('paymentId');
        $token = $request->get('token');
        $payer_id = $request->get('PayerID');

        try {
            $payment = PayPal::getById($id, $this->_apiContext);

            $paymentExecution = PayPal::PaymentExecution();

            $paymentExecution->setPayerId($payer_id);
            $executePayment = $payment->execute($paymentExecution, $this->_apiContext);    


            $booking->status = 1;
            $booking->total_paid = $booking->remaining_payment;
            $booking->remaining_payment = 0;
            $booking->log = $executePayment;
            $booking->save();


            Mail::send('emails.success-villa-booking', ['booking' => $booking], function ($m) use ($booking) {

                $m->to($booking->email, $booking->title.' '.$booking->first_name.' '.$booking->last_name)->subject(setting('core::site-name').' Booking Detail');
            });

            return redirect()->route('villamanager.bookings.payment',$booking->booking_number)
                ->withSuccess('Payment for booking #'.$booking->booking_number.' have successfull done. We also send detail of order to your email or contact us of any question.');;

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            
        } catch (Exception $ex) {
            
        }
            
        return redirect()->route('villamanager.bookings.payment',$booking->booking_number)
            ->withError('Payment for booking #'.$booking->booking_number.' get some error. Please try again or contact us of any question.');



        // Thank the user for the purchase
        return $request->all();
    }

    public function paypalcancel($id)
    {
        $booking = $this->booking->findByBookingNumber($id);
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
            
        return redirect()->route('villamanager.bookings.payment',$booking->booking_number)
            ->withError('Payment for booking #'.$booking->booking_number.' get some error. Please try again or contact us of any question.');
    }


    /**
     * Throw a 404 error page if the given page is not found
     * @param $page
     */
    private function throw404IfNotFound($page)
    {
        if (is_null($page)) {
            $this->app->abort('404');
        }
    }


    public function checkAvailability(Request $request,$id){
        $start = date('y-m-d h:i:s',strtotime($request->get('check_in').' 14:00:00'));
        $end = date('y-m-d h:i:s',strtotime($request->get('check_out').' 14:00:00'));

        $villa = Villa::whereDoesntHave('bookings', function ($q) use ($start,$end){

            $q->whereRaw('(check_in between "'.$start.'" and "'.$end.'" 
                OR "'.$start.'" between  check_in  and  check_out  
                OR  check_out between "'.$start.'" and "'.$end.'" 
                OR "'.$end.'" between check_in  and check_out)');

        })->whereDoesntHave('disableDates',function ($q) use ($start,$end){
            $q->whereRaw('(date between "'.$start.'" and "'.$end.'" )');
        })
            ->where('id',$id)->first();

        if(!$villa)
        {
            return response()->json([
                'status' => false,
                'message'   => 'Villa have booked on this date range. Please try other date.'
            ]);
        }
        return response()->json([
            'status' => true,
            'message'   => 'Villa available on this date range.',
            'price' => booking_price($villa),
            'length' => booking_length(),
        ]);

    }

    public function exportICS($id)
    {
        $bookings = Booking::where('villa_id',$id)->whereRaw(' check_in > now() ')->get();
        $ical = '';
        foreach ($bookings as $booking) {
            $ics = new ICS(array(
                'location' => $booking->villa ? $booking->villa->area? $booking->villa->area->name  : 'Bali' : 'Bali',
                'description' => $booking->villa->name . ' '  .$booking->booking_number,
                'dtstart' => $booking->check_in,
                'dtend' => $booking->check_out,
                'summary' => $booking->villa->name . ' '  .$booking->booking_number. ' '. $booking->first_name. ' '.$booking->last_name,
                'url' => route('villamanager.bookings.show',$booking->id)
            ));

            $ical = $ical. $ics->to_string();
        }
        File::put(public_path().'/assets/media/'.$id.'.ics',$ical);
        return (url('assets/media/'.$id.'.ics'));
    }
}

    