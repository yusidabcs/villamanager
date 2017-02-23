<?php namespace Modules\Villamanager\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface BookingRepository extends BaseRepository
{
	public function findByBookingNumber($id);

	public function all();
}
