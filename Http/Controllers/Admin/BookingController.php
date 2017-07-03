<?php namespace Modules\Villamanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Villamanager\ICS;
use Modules\Villamanager\Repositories\BookingRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Villamanager\Repositories\DisableDateRepository;
use Modules\Villamanager\Repositories\VillaRepository;
use Modules\Villamanager\Http\Requests\StoreBookingRequest;
use Nwidart\Modules\Facades\Module;
use Modules\Villamanager\Entities\Status;

class BookingController extends AdminBaseController
{
    private $booking;
    private $villa;
    private $disable_dates;

    public function __construct(BookingRepository $booking,VillaRepository $villa,DisableDateRepository $disable_dates)
    {
        parent::__construct();

        $this->booking = $booking;
        $this->villa = $villa;
        $this->disable_dates = $disable_dates;
        $this->assetManager->addAssets([
            'villamanager.js' => Module::asset('villamanager:js/main.js'),
            'bootstrap-datepicker.js' => Module::asset('villamanager:js/bootstrap-datepicker.min.js'),
            'bootstrap-datepicker.css' => Module::asset('villamanager:css/bootstrap-datepicker.min.css'),
        ]);
        $this->assetPipeline->requireJs('bootstrap-datepicker.js');
        $this->assetPipeline->requireCss('bootstrap-datepicker.css');
        $this->assetPipeline->requireJs('villamanager.js');

    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $bookings = $this->booking->all();
        $villas = $this->villa->all();
        if($request->get('view') == 'calendar'){

            $disable_dates = $this->disable_dates->all();

            return view('villamanager::admin.bookings.calendar', compact('bookings','villas','disable_dates'));
        }
        return view('villamanager::admin.bookings.index', compact('bookings'));
    }


    public function store(StoreBookingRequest $request)
    {
        $this->booking->create($request->all());

        return redirect()->back()
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('villamanager::bookings.title.bookings')]));;
    }


    public function edit($id)
    {
        $booking = $this->booking->find($id);
        $villas = $this->villa->all();

        if(request()->ajax()){
            return view('villamanager::admin.bookings.edit-modal', compact('booking','villas'));    
        }
        return view('villamanager::admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request,$id)
    {
        $booking = $this->booking->find($id);
        $booking->status = $request->get('status');
        $booking->save();

        return redirect()->back()
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('villamanager::bookings.title.bookings')]));
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
            $data['datasets'][0]['data'][] = $this->booking->getTotalBookingOnDate($date->format('Y-m-d'),['status' => Status::SUCCESS]);

            //cancel booking
            $data['datasets'][1]['data'][] = $this->booking->getTotalBookingOnDate($date->format('Y-m-d'),['status' => Status::CANCEL]);

            //total booking
            $data['datasets'][2]['data'][] = $this->booking->getTotalBookingByDate($date->format('Y-m-d'));

            //total commission
            $data['datasets'][3]['data'][] = $this->booking->getTotalBookingCommissionByDate($date->format('Y-m-d'));

        }

        $data['total']['cancel_booking'] = $this->booking->getTotalCancelBooking();
        $data['total']['paid_booking'] = $this->booking->getTotalPaidBooking();
        $data['total']['total_booking'] = currency($this->booking->getTotalBooking());
        $data['total']['total_commission'] = currency($this->booking->getTotalCommission());

        return response()->json($data);
    }


}