<?php namespace Modules\Villamanager\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Villamanager\Entities\Rate;
use Modules\Villamanager\Repositories\RateRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Villamanager\Entities\Villa;


class RateController extends AdminBaseController
{
    /**
     * @var RateRepository
     */
    private $rate;

    public function __construct(RateRepository $rate)
    {
        parent::__construct();

        $this->rate = $rate;
        $this->assetPipeline->requireJs('bootstrap-datepicker.js');
        $this->assetPipeline->requireCss('bootstrap-datepicker.css');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($villa_id)
    {
        $villa = Villa::find($villa_id);
        $rates = $villa->rates;
        return view('villamanager::admin.rates.index', compact('rates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($villa_id)
    {
        $villa = Villa::find($villa_id);
        $rates = $villa->fullcalender();
        return view('villamanager::admin.rates.create',compact('villa','rates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store($villa_id,Request $request)
    {
        if($request->get('id') != '' && $request->get('id') != 'new_rate'){
            $rate = Rate::find($request->get('id'));
            $this->rate->update($rate, $request->all());
            flash()->success(trans('core::core.messages.resource updated', ['name' => trans('villamanager::rates.title.rates')]));

        }else{
            $this->rate->create($request->all());

            flash()->success(trans('core::core.messages.resource created', ['name' => trans('villamanager::rates.title.rates')]));

        }
        return redirect()->back();
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Rate $rate
     * @return Response
     */
    public function edit(Rate $rate)
    {
        return view('villamanager::admin.rates.edit', compact('rate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Rate $rate
     * @param  Request $request
     * @return Response
     */
    public function update(Rate $rate, Request $request)
    {

        $this->rate->update($rate, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('villamanager::rates.title.rates')]));

        return redirect()->route('admin.villamanager.rate.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Rate $rate
     * @return Response
     */
    public function destroy(Rate $rate,Request $request)
    {
        $this->rate->destroy($rate);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('villamanager::rates.title.rates')]));

        if($request->ajax()){
            return response()->json(['message' => trans('core::core.messages.resource deleted', ['name' => trans('villamanager::rates.title.rates')])]);
        }
        return redirect()->route('admin.villamanager.rate.index');
    }
}
