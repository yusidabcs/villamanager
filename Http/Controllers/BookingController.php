<?php namespace Modules\Villamanager\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Villamanager\Repositories\DiscountRepository;
use Modules\Villamanager\Repositories\VillaRepository;
use Illuminate\Http\Request;
use Modules\Villamanager\Entities\Villa;
use Modules\Villamanager\Http\Requests\StoreBookingRequest;
use Modules\Villamanager\Repositories\BookingRepository;
use Paypal;
use Mail;

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


    public function __construct(VillaRepository $villa,BookingRepository $booking, Application $app, DiscountRepository $discount)
    {
        parent::__construct();
        $this->villa = $villa;
        $this->app = $app;
        $this->booking = $booking;
        $this->discount = $discount;

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
    }

    public function show(Request $request, $id)
    {
        $start = $request->get('check_in').' 14:00:00';
        $end = $request->get('check_out').' 12:00:00';

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
            flash()->error('Villa have booked on this date range. Please try other date.');
            return redirect()->back();
        }

        $this->throw404IfNotFound($villa);

        $template = 'bookings.index';

        return view($template, compact('villa'));
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
        $this->discount->claimDiscountByCode();

        $booking = $this->booking->create($request->all());

        Mail::send('emails.create-villa-booking', ['booking' => $booking], function ($m) use ($booking) {

            $m->to($booking->email, $booking->title.' '.$booking->first_name.' '.$booking->last_name)->subject(setting('core::site-name').' Booking Detail');
        });

        Mail::send('emails.create-villa-booking', ['booking' => $booking], function ($m) use ($booking) {

            $m->to(setting('core::email'), $booking->title.' '.$booking->first_name.' '.$booking->last_name)->subject(setting('core::site-name').' New Booking Detail');
        });

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('villamanager::bookings.title.bookings')]));

        return redirect()->route('villamanager.bookings.payment',$booking->booking_number);

    }

    public function payment($id)
    {
        $booking = $this->booking->findByBookingNumber($id);
        $villa = $booking->villa;
        $template = 'bookings.payment';
        return view($template, compact('booking','villa'));
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
        $amount->setTotal($booking->total_paid); 

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
            $booking->log = $executePayment;
            $booking->save();


            Mail::send('emails.paid-villa-booking', ['booking' => $booking], function ($m) use ($booking) {

                $m->to($booking->email, $booking->title.' '.$booking->first_name.' '.$booking->last_name)->subject(setting('core::site-name').' Booking Detail');
            });
            flash()->success('Payment for booking #'.$booking->booking_number.' have successfull done. We also send detail of order to your email or contact us of any question.');

            return redirect()->route('villamanager.bookings.payment',$booking->booking_number);

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            
        } catch (Exception $ex) {
            
        }

        flash()->error('Payment for booking #'.$booking->booking_number.' get some error. Please try again or contact us of any question.');
            
        return redirect()->route('villamanager.bookings.payment',$booking->booking_number);



        // Thank the user for the purchase
        return $request->all();
    }

    public function paypalcancel($id)
    {
        $booking = $this->booking->findByBookingNumber($id);
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        flash()->error('Payment for booking #'.$booking->booking_number.' get some error. Please try again or contact us of any question.');
            
        return redirect()->route('villamanager.bookings.payment',$booking->booking_number);
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
}

    