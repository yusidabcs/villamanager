<?php
/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 1/29/17
 * Time: 11:29 AM
 */

namespace Modules\Villamanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Media\Repositories\FileRepository;
use Modules\Villamanager\Entities\Area;
use Modules\Villamanager\Http\Requests\StoreAreaRequest;
use Modules\Villamanager\Repositories\AreaRepository;

class AreaController extends AdminBaseController
{
    public $area,$file;

    public function __construct(AreaRepository $areaRepository,FileRepository $fileRepository)
    {
        parent::__construct();
        $this->area = $areaRepository;
        $this->file = $fileRepository;
    }

    public function index()
    {
        $areas = $this->area->all();
        return view('villamanager::admin.areas.index', compact('areas'));
    }

    public function create()
    {
        $areas = $this->area->all();
        return view('villamanager::admin.areas.create', compact('areas'));
    }

    public function store(StoreAreaRequest $request)
    {
        $this->area->create($request->all());
        return redirect()->route('admin.villamanager.area.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('villamanager::areas.title.areas')]));;
    }

    public function edit(Area $area)
    {
        $thumbnail = $this->file->findFileByZoneForEntity('area_image', $area);
        $areas = $this->area->all();
        return view('villamanager::admin.areas.edit', compact('area','areas','thumbnail'));
    }

    public function update(Request $request,Area $area)
    {
        $this->area->update($area, $request->all());


        if ($request->get('button') === 'index') {
            return redirect()->route('admin.villamanager.area.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('villamanager::areas.title.areas')]));
        }

        return redirect()->back()
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('villamanager::areas.title.areas')]));
    }

    public function destroy(Area $area)
    {
        $this->area->destroy($area);

        return redirect()->route('admin.villamanager.area.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('villamanager::areas.title.areas')]));
    }
}