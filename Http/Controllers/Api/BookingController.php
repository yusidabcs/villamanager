<?php namespace Modules\Villamanager\Http\Controllers\Api;

use Carbon\Carbon;
use ICal\ICal;
use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\User\Contracts\Authentication;
use Modules\Villamanager\Entities\DisableDate;
use Modules\Villamanager\Entities\Status;
use Modules\Villamanager\Repositories\BookingRepository;
use Modules\Villamanager\Repositories\DisableDateRepository;
use Modules\Villamanager\Repositories\VillaRepository;
use Illuminate\Http\Request;
use Modules\Villamanager\Entities\Villa;

class BookingController extends BasePublicController
{
    /**
     * @var PageRepository
     */
    private $villa;
    private $bookings;
    private $disable_dates;
    private $user;
    /**
     * @var Application
     */
    private $app;

    public function __construct(VillaRepository $villa,BookingRepository $bookingRepository,DisableDateRepository $disableDateRepository, Application $app,Authentication $user)
    {
        parent::__construct();
        $this->villa = $villa;
        $this->app = $app;
        $this->bookings = $bookingRepository;
        $this->disable_dates = $disableDateRepository;
        $this->user = $user;
    }

    public function checkprice(Request $request, $id)
    {
        $response = [
            'message'   => 'Villa available on this date range.',
            'status'    => true
        ];
        //validate date
        $start = date('Y-m-d H:i:s',strtotime($request->get('check_in').' 14:00:00'));
        $end = date('Y-m-d H:i:s',strtotime($request->get('check_out').' 12:00:00'));
        $total_day = floor( (strtotime($request->get('check_out')) - strtotime($request->get('check_in'))) / (60 * 60 * 24));

        $villa = Villa::where('id',$id)->whereDoesntHave('bookings', function ($q) use ($start,$end){

            $q->whereRaw('(check_in between "'.$start.'" and "'.$end.'" 
                OR "'.$start.'" between  check_in  and  check_out  
                OR  check_in between "'.$start.'" and "'.$end.'" 
                OR "'.$end.'" between check_in  and check_out) and status != 2');

        })->whereDoesntHave('disableDates',function ($q) use ($start,$end){
            $q->whereRaw('(date between "'.$start.'" and "'.$end.'" )');
        })->first();
        if(!$villa)
            return response()->json([
                'status' => false,
                'message'   => 'Villa have booked on this date range. Please try other date.'
            ]);

        if($villa->minimum_stay > $total_day)
        {
            return response()->json([
                'status' => false,
                'message'   => 'The minimum stay for this property is '.$villa->minimum_stay.' day(s)'
            ]);
        }

        $user = \Cartalyst\Sentinel\Laravel\Facades\Sentinel::findById($request->get('user_id'));
        $discount_code = request()->get('discount_code');
        $total_booking = floatval(str_replace(',', '.', str_replace('.', '', booking_price($villa,false,$user))));
        $total_discount = 0;
        if($discount_code != '')
        {
            $discount = \Modules\Villamanager\Entities\Discount::where('code',$discount_code)->first();
            if($discount)
            {
                $today = strtotime(date('Y-m-d'));
                $discount_start = strtotime($discount->start_date);
                $discount_end = strtotime($discount->end_date);

                if (($today >= $discount_start) && ( $today <= $discount_end))
                {
                    if($discount->type == 1)
                    {
                        if($discount->minimumPayment <= $total_booking)
                        {
                            $total_booking-=$discount->discount;
                            if($request->has('check') ){
                                $response['message'] = 'Discount code found.';
                            }

                            $response['discount'] = $discount;
                            $total_discount = $discount->discount;
                        }
                        else
                        {
                            $response['error'] = 'You should have minimum order of '.price_format($discount->minimumPayment).' to use this discount code.';
                            $response['status'] = false;
                        }
                    }
                    elseif($discount->type == 2)
                    {
                        if($discount->minimumPayment <= $total_booking)
                        {
                            $discount_nominal = $discount->discount / 100 * $total_booking;
                            $total_booking-=$discount_nominal;
                            if($request->has('check') ){
                                $response['message'] = 'Discount code found.';
                            }

                            $response['discount'] = $discount;
                            $total_discount = $discount_nominal;
                        }
                        else
                        {
                            $response['error'] = 'You should have minimum order of '.price_format($discount->minimumPayment).' to use this discount code.';
                            $response['status'] = false;
                        }
                    }
                }else{
                    $response['error'] = 'Discount code can\'t used at this time';
                    $response['status'] = false;
                }
            }else{
                $response['error'] = 'Discount code not found.';
                $response['status'] = false;
            }
        }
        $response['total_booking_price'] = currency($total_booking,'USD',$request->get('currency'));
        $response['total_discount'] = currency($total_discount,'USD',$request->get('currency'));

        $response['length'] = booking_length();




        return response()->json($response);
    }
    public function unavailableDate(Request $request)
    {
        $bookings = $this->bookings->all();
        $disable_dates = $this->disable_dates->all();
        return response()->json(array_merge($bookings,$disable_dates));
    }
    public function bookingdate(Request $request, $id)
    {
        $villa = $this->villa->find($id);
        return response()->json([
            'booking_date' => disabledDays($villa),
            'max_person'    => $villa->maxPerson()
        ]);

    }

    public function import(Request $request,$id){

        //mDisableDate::deleteOldData();
        $ical = new ICal(request('ics_file'), array(
            'defaultSpan'           => 2,
            'defaultWeekStart'      => 'MO',
            'skipRecurrence'        => false,
            'useTimeZoneWithRRules' => false,
        ));
        foreach ($ical->events() as $event) {

            $start_date = Carbon::createFromFormat('Y-m-d',date('Y-m-d' , strtotime($event->dtstart)));
            $end_date = Carbon::createFromFormat('Y-m-d',date('Y-m-d' , strtotime('-1 day',strtotime($event->dtend))));
            $disable_date = [];

            for($date = $start_date; $date->lte($end_date); $date->addDay()) {
                $disable_date[] = [
                    'villa_id' => $id,
                    'date' => $date->format('Y-m-d 14:00:00'),
                    'reason' => $event->summary
                ];

                $rs = DisableDate::updateOrCreate([
                    'villa_id' => $id,
                    'date' => $date->format('Y-m-d 14:00:00'),
                    'reason' => $event->summary
                ]);
            }

        }
        if($request->ajax()){
            return response([
                'message' => trans('core::core.messages.resource created', ['name' => trans('villamanager::disabledates.title.disabledates')])
            ]);
        }
    }

    public function bookingReport()
    {
        $data = array();
        $daterange = new \DatePeriod(
            new \DateTime(date('Y-m-01',strtotime("now"))),
            new \DateInterval('P1D'),
            new \DateTime(date("Y-m-t",strtotime("now")))
        );
        $data['datasets'][0] = [
            'label' => "Paid Bookings",
            'fillColor' => "rgb(210, 214, 222)",
            'strokeColor' =>    "rgb(210, 214, 222)",
            'pointColor'    =>  "rgb(210, 214, 222)",
            'pointStrokeColor'  =>  "#c1c7d1",
            'pointHighlightFill'    =>  "#fff",
            'pointHighlightStroke'  =>  "rgb(220,220,220)",
        ];
        $data['datasets'][1] = [
            'label' => "Cancel Bookings",
            'fillColor' => "rgb(210, 214, 222)",
            'strokeColor' =>    "rgb(210, 214, 222)",
            'pointColor'    =>  "rgb(210, 214, 222)",
            'pointStrokeColor'  =>  "#c1c7d1",
            'pointHighlightFill'    =>  "#fff",
            'pointHighlightStroke'  =>  "rgb(220,220,220)",
            'data'  =>   [65, 59, 80, 81, 56, 55, 40]
        ];
        $data['datasets'][2] = [
            'label' => "Total Bookings",
            'fillColor' => "rgb(210, 214, 222)",
            'strokeColor' =>    "rgb(210, 214, 222)",
            'pointColor'    =>  "rgb(210, 214, 222)",
            'pointStrokeColor'  =>  "#c1c7d1",
            'pointHighlightFill'    =>  "#fff",
            'pointHighlightStroke'  =>  "rgb(220,220,220)",
        ];
        $data['datasets'][3] = [
            'label' => "Commissions",
            'fillColor' => "rgb(210, 214, 222)",
            'strokeColor' =>    "rgb(210, 214, 222)",
            'pointColor'    =>  "rgb(210, 214, 222)",
            'pointStrokeColor'  =>  "#c1c7d1",
            'pointHighlightFill'    =>  "#fff",
            'pointHighlightStroke'  =>  "rgb(220,220,220)",
            'data'  =>   [65, 59, 80, 81, 56, 55, 40]
        ];

        foreach($daterange as $date){
            $data['labels'][] = $date->format("d M");

            //paid booking
            $data['datasets'][0]['data'][] = $this->bookings->getTotalBookingOnDate($date->format('Y-m-d'),['status' => Status::SUCCESS]);

            //cancel booking
            $data['datasets'][1]['data'][] = $this->bookings->getTotalBookingOnDate($date->format('Y-m-d'),['status' => Status::CANCEL]);

            //total booking
            $data['datasets'][2]['data'][] = $this->bookings->getTotalBookingByDate($date->format('Y-m-d'));

            //total commission
            $data['datasets'][3]['data'][] = $this->bookings->getTotalBookingCommissionByDate($date->format('Y-m-d'));

        }

        $data['total']['cancel_booking'] = $this->bookings->getTotalCancelBooking();
        $data['total']['paid_booking'] = $this->bookings->getTotalPaidBooking();
        $data['total']['total_booking'] = currency($this->bookings->getTotalBooking());
        $data['total']['total_commission'] = currency($this->bookings->getTotalCommission());

        return response()->json($data);
    }
}
