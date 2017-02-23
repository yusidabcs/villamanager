<?php namespace Modules\Villamanager\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Core\Contracts\Authentication;
use Modules\Core\Console\Installers\Scripts\ModuleAssets;
use Modules\Core\Foundation\Asset\Manager\AssetManager;

use Modules\Villamanager\Entities\Villa;
use Modules\Villamanager\Repositories\AreaRepository;
use Modules\Villamanager\Repositories\CategoryRepository;
use Modules\Villamanager\Repositories\VillaRepository;
use Modules\Villamanager\Repositories\FacilityRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Media\Entities\File;
use Modules\Villamanager\Http\Requests\StoreVillaRequest;
use Modules\Villamanager\Http\Requests\UpdateVillaRequest;
use Pingpong\Modules\Facades\Module;

class VillaController extends BaseVillaModuleController
{
    /**
     * @var VillaRepository
     */
    protected $villa,$facilities,$area,$auth,$category;

    public function __construct(VillaRepository $villa,
                                FacilityRepository $facilities,
                                AreaRepository $areaRepository,
                                Authentication $authentication,
                                CategoryRepository $categoryRepository)
    {
        parent::__construct();

        $this->villa = $villa;
        $this->facilities = $facilities;
        $this->area = $areaRepository;
        $this->auth = $authentication;
        $this->category = $categoryRepository;
        $this->assetManager->addAssets([
            'villa.css' => Module::asset('villamanager:css/villa.css')
        ]);
        $this->assetPipeline->requireCss('villa.css');
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = $this->auth->check();
        $villas = $this->villa->all();
        return view('villamanager::admin.villas.index', compact('villas','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $facilities = $this->facilities->all();
        $areas = $this->area->all();
        $categories = $this->category->all();

        $files = File::whereIn('id',session('villa_image'))->get();
        return view('villamanager::admin.villas.create', compact('facilities','files','areas','categorties'));
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

        if ($request->get('button') === 'index') {
            return redirect()->route('admin.villamanager.villa.index');
        }
        return redirect()->back();

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
        $areas = $this->area->all();
        $categories = $this->category->all();
        return view('villamanager::admin.villas.edit', compact('facilities','villa','areas','categories'));
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
