<?php
/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 3/9/17
 * Time: 7:58 PM
 */

namespace Modules\Villamanager\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Villamanager\Repositories\AreaRepository;

class AreaController extends Controller
{
    public function index(AreaRepository $areaRepository)
    {
        return response()->json($areaRepository->api());
    }

}