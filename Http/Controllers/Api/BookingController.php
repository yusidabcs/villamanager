<?php namespace Modules\Villamanager\Http\Controllers\Api;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Villamanager\Repositories\BookingRepository;
use Modules\Villamanager\Repositories\DisableDateRepository;
use Modules\Villamanager\Repositories\VillaRepository;
use Illuminate\Http\Request;
use Modules\Villamanager\Entities\Villa;

class BookingController extends BasePublicController
{
    /**
     * @var PageRepository
     */
    private $villa;
    private $bookings;
    private $disable_dates;
    /**
     * @var Application
     */
    private $app;

    public function __construct(VillaRepository $villa,BookingRepository $bookingRepository,DisableDateRepository $disableDateRepository, Application $app)
    {
        parent::__construct();
        $this->villa = $villa;
        $this->app = $app;
        $this->bookings = $bookingRepository;
        $this->disable_dates = $disableDateRepository;
    }

    public function checkprice(Request $request, $id)
    {
        $response = [];
        $villa = $this->villa->find($id);

        $discount_code = request()->get('discount_code');
        $total_booking = floatval(str_replace(',', '.', str_replace('.', '', booking_price($villa))));
        if($discount_code != '')
        {
            $discount = \Modules\Villamanager\Entities\Discount::where('code',$discount_code)->first();
            if($discount)
            {
                $today = strtotime(date('Y-m-d'));
                $discount_start = strtotime($discount->start_date);
                $discount_end = strtotime($discount->end_date);

                if (($today >= $discount_start) && ( $today <= $discount_end))
                {
                    if($discount->type == 1)
                    {
                        if($discount->minimumPayment <= $total_booking)
                        {
                            $total_booking-=$discount->discount;
                            $response['message'] = 'Discount code found.';
                            $response['discount'] = $discount;
                        }
                        else
                        {
                            $response['error'] = 'You should have minimum order of '.price_format($discount->minimumPayment).' to use this discount code.';
                        }
                    }
                    elseif($discount->type == 2)
                    {
                        if($discount->minimumPayment <= $total_booking)
                        {
                            $discount_nominal = $discount->discount / 100 * $total_booking;
                            $total_booking-=$discount_nominal;
                            $response['message'] = 'Discount code found.';
                            $response['discount'] = $discount;
                        }
                        else
                        {
                            $response['error'] = 'You should have minimum order of '.price_format($discount->minimumPayment).' to use this discount code.';
                        }
                    }
                }else{
                    $response['error'] = 'Discount code can\'t used at this time';
                }
            }else{
                $response['error'] = 'Discount code not found.';
            }
        }
        $response['price'] = booking_price($villa);
        $percentage = setting('villamanager::booking_percentage');
        $response['total_booking_price'] = price_format($percentage/100 * $total_booking);

        return response()->json($response);
    }
    public function unavailableDate(Request $request)
    {
        $bookings = $this->bookings->all();
        $disable_dates = $this->disable_dates->all();
        return response()->json(array_merge($bookings,$disable_dates));
    }
    public function bookingdate(Request $request, $id)
    {
        $villa = $this->villa->find($id);
        return response()->json([
            'booking_date' => disabledDays($villa),
            'max_person'    => $villa->maxPerson()
        ]);

    }
}
