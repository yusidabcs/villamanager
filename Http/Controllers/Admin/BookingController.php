<?php namespace Modules\Villamanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Villamanager\Repositories\BookingRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Villamanager\Repositories\DisableDateRepository;
use Modules\Villamanager\Repositories\VillaRepository;
use Modules\Villamanager\Http\Requests\StoreBookingRequest;
use Pingpong\Modules\Facades\Module;

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
            'bootstrap-datepicker.js' => Module::asset('villamanager:js/bootstrap-datepicker.min.js'),
            'bootstrap-datepicker.css' => Module::asset('villamanager:css/bootstrap-datepicker.min.css'),
        ]);
        $this->assetPipeline->requireJs('bootstrap-datepicker.js');
        $this->assetPipeline->requireCss('bootstrap-datepicker.css');

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

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('villamanager::bookings.title.bookings')]));         

        return redirect()->back();
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

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('villamanager::bookings.title.bookings')]));

        return redirect()->back();
    }


}