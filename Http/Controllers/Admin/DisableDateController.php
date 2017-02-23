<?php namespace Modules\Villamanager\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Villamanager\Entities\DisableDate;
use Modules\Villamanager\Repositories\DisableDateRepository;
use Pingpong\Modules\Routing\Controller;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class DisableDateController extends AdminBaseController {

    private $disable_date;

    public function __construct(DisableDateRepository $disableDateRepository)
    {
        parent::__construct();

        $this->disable_date = $disableDateRepository;
    }
	public function store(Request $request)
	{
        $start_date = Carbon::createFromFormat('Y-m-d',$request->get('start_date'));
        $end_date = Carbon::createFromFormat('Y-m-d',$request->get('end_date'));
        $disable_date = [];

        for($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $disable_date[] = [
                'villa_id' => $request->get('villa_id'),
                'date' => $date->format('Y-m-d'),
                'reason' => $request->get('reason')
            ];

            $rs = DisableDate::firstOrNew([
                'villa_id' => $request->get('villa_id'),
                'date' => $date->format('Y-m-d'),
                'reason' => $request->get('reason')
            ]);
            $rs->save();
            $date->format('Y-m-d');
        }

        if($request->ajax()){
            return response([
                'message' => trans('core::core.messages.resource created', ['name' => trans('villamanager::disabledates.title.disabledates')])
            ]);
        }
        flash()->success(trans('core::core.messages.resource created', ['name' => trans('villamanager::disabledates.title.disabledates')]));

        return redirect()->back();
	}

    public function destroy(DisableDate $disableDate,Request $request)
    {
        $this->disable_date->destroy($disableDate);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('villamanager::disabledates.title.disabledates')]));

        if ($request->ajax()) {
            return response()->json(['message' => trans('core::core.messages.resource deleted', ['name' => trans('villamanager::disabledates.title.disabledates')])]);
        }
        return redirect()->route('admin.villamanager.rate.index');
    }
}