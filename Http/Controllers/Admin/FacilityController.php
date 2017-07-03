<?php namespace Modules\Villamanager\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Villamanager\Entities\Facility;
use Modules\Villamanager\Repositories\FacilityRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class FacilityController extends AdminBaseController
{
    /**
     * @var FacilityRepository
     */
    private $facility;

    public function __construct(FacilityRepository $facility)
    {
        parent::__construct();

        $this->facility = $facility;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $facilities = $this->facility->all();

        return view('villamanager::admin.facilities.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('villamanager::admin.facilities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->facility->create($request->all());

        return redirect()->route('admin.villamanager.facility.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('villamanager::facilities.title.facilities')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Facility $facility
     * @return Response
     */
    public function edit(Facility $facility)
    {
        return view('villamanager::admin.facilities.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Facility $facility
     * @param  Request $request
     * @return Response
     */
    public function update(Facility $facility, Request $request)
    {
        $this->facility->update($facility, $request->all());

        return redirect()->route('admin.villamanager.facility.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('villamanager::facilities.title.facilities')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Facility $facility
     * @return Response
     */
    public function destroy(Facility $facility)
    {
        $this->facility->destroy($facility);

        return redirect()->route('admin.villamanager.facility.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('villamanager::facilities.title.facilities')]));
    }
}
