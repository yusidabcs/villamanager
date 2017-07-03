<?php namespace Modules\Villamanager\Repositories\Cache;

use Modules\Villamanager\Repositories\BookingRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheBookingDecorator extends BaseCacheDecorator implements BookingRepository
{
    public function __construct(BookingRepository $booking)
    {
        parent::__construct();
        $this->entityName = 'villamanager.bookings';
        $this->repository = $booking;
    }

    public function findByBookingNumber($id)
    {
        return $this->repository->findByBookingNumber($id);
    }

    public function all()
    {
        return $this->repository->all();

    }

    public function findByUser($id)
    {
        return $this->repository->findByUser($id);
    }

    public function getTotalBookingOnDate($date,$opt = [])
    {
        return $this->repository->getTotalBookingOnDate($date,$opt);
    }

    public function getTotalBookingByDate($opt)
    {
        return $this->repository->getTotalBooking($opt);
    }

    public function getTotalBookingCommissionByDate($date)
    {
        return $this->repository->getTotalBookingCommissionByDate($date);
    }

    public function getTotalBooking()
    {
        return $this->repository->getTotalBooking();
    }

    public function getTotalPaidBooking()
    {
        return $this->repository->getTotalPaidBooking();
    }

    public function getTotalCancelBooking()
    {
        return $this->repository->getTotalCancelBooking();
    }

    public function getTotalCommission()
    {
        return $this->repository->getTotalCommission();
    }

    public function todayBookings()
    {
        return $this->repository->todayBookings();
    }


}
