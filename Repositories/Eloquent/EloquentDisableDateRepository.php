<?php
/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 1/24/17
 * Time: 4:19 PM
 */

namespace Modules\Villamanager\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Villamanager\Repositories\DisableDateRepository;

class EloquentDisableDateRepository extends EloquentBaseRepository implements DisableDateRepository
{
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