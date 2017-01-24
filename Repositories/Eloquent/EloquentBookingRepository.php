<?php namespace Modules\Villamanager\Repositories\Eloquent;

use Modules\Villamanager\Repositories\BookingRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentBookingRepository extends EloquentBaseRepository implements BookingRepository
{

	public function findByBookingNumber($id){
		
		return $this->model->with('villa')->where('booking_number', $id)->first();

	}

	public function all(){


		if(request()->has('view')){

			if(request()->has('villa')){
				
				$bookings = $this->model->where('villa_id',request()->get('villa'))->get();

			}else{
				
				$bookings = $this->model->all();
				
			}
			$rs  = [];
			foreach ($bookings as $booking) {
				$rs[] = $booking->fullcalender();
			}

			return $rs;	
		}
		return $this->model->all();

	}
}
