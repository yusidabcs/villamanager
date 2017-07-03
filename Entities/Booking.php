<?php namespace Modules\Villamanager\Entities;
   
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

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
    	'country_id',

        'total',
        'total_paid',
        'remaining_payment',
        'total_commission',
        'status',
        'payment_date',
        'payment_type',

        'discount_code',
        'total_discount',

        'payment_type',
        'user_id'
        
    ];

    public function villa(){
        return $this->belongsTo(Villa::class,'villa_id');
    }

    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    public function status(){
        $status = new Status();
        return $status->get($this->status);
    }

    public function statusHTML(){
        $status = new Status();
        return $status->getHTML($this->status);
    }
    public function emailTemplate(){
        $status = new Status();
        return $status->template($this->status);
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function fullcalender(){
        $dt = Carbon::createFromFormat('Y-m-d H:i:s',$this->check_out);

        return [
            'id' => $this->id,
            'title' => 'Booking for '. ($this->villa ? $this->villa->name : '').' #' .$this->booking_number,
            'start' => $this->check_in,
            'end' => $dt->subHour(12)->format('Y-m-d H:i:s'),
            'url' => url('backend/villamanager/bookings/'.$this->id.'/edit'),
            'total_guest' => $this->adult_guest,
            'color' => ($this->status == 0 ? '#f0ad4e' : ($this->status == 1 ? '#5cb85c' : '#585454')),
            'editable' => false,
            'startEditable' => false,
            'resourceEditable' => false,
            'allDay' => false,
        ];
    }
}