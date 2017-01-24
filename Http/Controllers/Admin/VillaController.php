<?php namespace Modules\Villamanager\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Villamanager\Entities\Villa;
use Modules\Villamanager\Repositories\VillaRepository;
use Modules\Villamanager\Repositories\FacilityRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Media\Entities\File;
use Modules\Villamanager\Http\Requests\StoreVillaRequest;
use Modules\Villamanager\Http\Requests\UpdateVillaRequest;

class VillaController extends BaseVillaModuleController
{
    /**
     * @var VillaRepository
     */
    private $villa;

    public function __construct(VillaRepository $villa,FacilityRepository $facilities)
    {
        parent::__construct();

        $this->villa = $villa;
        $this->facilities = $facilities;
        $this->assetPipeline->requireCss('villa.css');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $villas = $this->villa->all();
        return view('villamanager::admin.villas.index', compact('villas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $facilities = $this->facilities->all();

        $files = File::whereIn('id',session('villa_image'))->get();
        return view('villamanager::admin.villas.create', compact('facilities','files'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(StoreVillaRequest $request)
    {
        $villa = $this->villa->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('villamanager::villas.title.villas')]));

        return redirect()->route('admin.villamanager.villa.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Villa $villa
     * @return Response
     */
    public function edit(Villa $villa)
    {
        $facilities = $this->facilities->all();
        return view('villamanager::admin.villas.edit', compact('facilities','villa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Villa $villa
     * @param  Request $request
     * @return Response
     */
    public function update(Villa $villa, UpdateVillaRequest $request)
    {
        $this->villa->update($villa, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('villamanager::villas.title.villas')]));

        if ($request->get('button') === 'index') {
            return redirect()->route('admin.villamanager.villa.index');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Villa $villa
     * @return Response
     */
    public function destroy(Villa $villa)
    {
        $this->villa->destroy($villa);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('villamanager::villas.title.villas')]));

        return redirect()->route('admin.villamanager.villa.index');
    }
}
