<?php namespace Modules\Villamanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Villamanager\Entities\Discount;
use Modules\Villamanager\Http\Requests\StoreDiscountRequest;
use Modules\Villamanager\Repositories\DiscountRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Villamanager\Repositories\VillaRepository;

class DiscountController extends AdminBaseController
{
    private $discount;
    private $villa;

    public function __construct(DiscountRepository $discount,VillaRepository $villa)
    {
        parent::__construct();

        $this->discount = $discount;
        $this->villa = $villa;

    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $discounts = $this->discount->all();
        $villas = $this->villa->all();

        return view('villamanager::admin.discounts.index', compact('discounts','villas'));
    }

    public function create(Request $request)
    {
        $this->assetPipeline->requireJs('bootstrap-datepicker.js');
        $this->assetPipeline->requireCss('bootstrap-datepicker.css');
        $villas = $this->villa->all();
        return view('villamanager::admin.discounts.create', compact('villas'));
    }

    public function store(StoreDiscountRequest $request)
    {
        $this->discount->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('villamanager::discounts.title.discounts')]));

        return redirect()->to(route('admin.villamanager.discount.index'));
    }


    public function edit(Discount $discount)
    {
        $villas = $this->villa->all();

        if(request()->ajax()){
            return view('villamanager::admin.discounts.edit-modal', compact('discount','villas'));
        }
        return view('villamanager::admin.discounts.edit', compact('discount','villas'));
    }

    public function update(Request $request,Discount $discount)
    {
        $this->discount->update($discount, $request->all());
        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('villamanager::discounts.title.discounts')]));
        return redirect()->back();
    }

    public function destroy(Discount $discount)
    {
        $this->discount->destroy($discount);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('villamanager::discounts.title.discounts')]));

        return redirect()->route('admin.villamanager.discount.index');
    }


}