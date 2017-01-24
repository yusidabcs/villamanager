<?php namespace Modules\Villamanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Villamanager\Repositories\InquiryRepository;
use Modules\Villamanager\Repositories\VillaRepository;

class InquiryController extends AdminBaseController
{
    private $inquiry;
    private $villa;

    public function __construct(VillaRepository $villa,InquiryRepository $inquiry)
    {
        parent::__construct();

        $this->villa = $villa;
        $this->inquiry = $inquiry;
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
        $inquiries = $this->inquiry->all();

        return view('villamanager::admin.inquiries.index', compact('inquiries'));
    }

}