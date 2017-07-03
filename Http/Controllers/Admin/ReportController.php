<?php
/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 3/30/17
 * Time: 5:20 PM
 */

namespace Modules\Villamanager\Http\Controllers\Admin;

use ICal\ICal;
use Modules\User\Repositories\UserRepository;
use Modules\Villamanager\Repositories\BookingRepository;
use Modules\Villamanager\Repositories\VillaRepository;


class ReportController extends BaseVillaModuleController
{
    public function __construct(VillaRepository $villaRepository,BookingRepository $bookingRepository, UserRepository $userRepository)
    {
        $this->villa = $villaRepository;
        $this->booking = $bookingRepository;
        $this->user = $userRepository;
    }
    public function index(){
        return response()->json([
            'total_villa' => $this->villa->all()->count(),
            'total_booking' => $this->booking->all()->count(),
            'total_unapproved_villa' => $this->villa->unapproved(),
            'total_user'    => $this->user->all()->count()
        ]);

        return view('villamanager::admin.reports.index');

    }

}