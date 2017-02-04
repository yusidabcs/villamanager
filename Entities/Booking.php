<?php namespace Modules\Villamanager\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

    protected $table = 'villamanager__bookings';
    
    protected $fillable = [
        'booking_number',
        'villa_id',

    	'check_in',
    	'check_out',
    	'adult_guest',
    	'child_guest',
    	'child_age',
    	'airport_transfer',
    	'arival_flight_number',
    	'arival_flight_date',
    	'departure_flight_date',
    	'departure_flight_number',

    	'first_name',
    	'last_name',
    	'email',
    	'phone',
    	'address',
    	'country',

        'total',
        'total_paid',
        'remaining_payment',
        'status',
        'payment_date',
        'payment_type',

        'discount_code',
        'total_discount'
        
    ];

    public function villa(){
        return $this->belongsTo(Villa::class,'villa_id');
    }

    public function fullcalender(){
        return [
            'id' => $this->id,
            'title' => $this->villa->name.' | ' .$this->check_in . " - ".$this->check_out. ' | '.$this->title.' '.$this->first_name.' '.$this->last_name,
            'start' => $this->check_in,
            'end' => $this->check_out,
            'url' => url('backend/villamanager/bookings/'.$this->id.'/edit'),
            'color' => ($this->status == 0 ? '#f0ad4e' : ($this->status == 1 ? '#5cb85c' : '#585454')),
            'editable' => false,
            'startEditable' => false,
            'resourceEditable' => false
        ];
    }
}