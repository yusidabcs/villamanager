<?php namespace Modules\Villamanager\Entities;
   
use Illuminate\Database\Eloquent\Model;

class VillaBooking extends Model {

    protected $table = 'villamanager__bookings';
    protected $fillable = [

    	'villa_id',
    	'start_date',
    	'end_date',
    	'rate'
    ];

    public function fullcalender(){
    	return [
    		'id' => $this->id,
    		'title' => $this->rate . " USD ",
    		'start' => $this->start_date,
    		'end' => $this->end_date,
    		'color' => "#".substr(md5(rand()), 0, 6)
    	];
    }

}

