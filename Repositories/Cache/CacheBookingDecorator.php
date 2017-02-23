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
        // TODO: Implement findByBookingNumber() method.
    }
}
