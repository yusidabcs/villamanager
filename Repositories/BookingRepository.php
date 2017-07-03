<?php namespace Modules\Villamanager\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface BookingRepository extends BaseRepository
{
	public function findByBookingNumber($id);

	public function all();

    public function findByUser($id);

    public function getTotalBookingOnDate($date,$opt = []);

    public function getTotalBookingByDate($opt);

    public function getTotalBookingCommissionByDate($date);

    public function getTotalBooking();
    public function getTotalPaidBooking();
    public function getTotalCancelBooking();
    public function getTotalCommission();

    public function todayBookings();
}
