<?php namespace Modules\Villamanager\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table = 'villamanager__rates';
    protected $fillable = [

    	'villa_id',
    	'start_date',
    	'end_date',
    	'rate',
        'name'
    ];

    public function villa(){
        return $this->belongsTo(Villa::class,'villa_id');
    }
    public function fullcalender(){
        $date = date_create($this->end_date);
        date_add($date, date_interval_create_from_date_string('1 days'));

    	return [
    		'id' => $this->id,
    		'title' => $this->name.' ~ ' .$this->rate . " USD ",
    		'start' => $this->start_date.' 00:00:00',
    		'end' => date_format($date, 'Y-m-d'),
    		'color' => "#".substr(md5(rand()), 0, 6),
            'editable' => true,

            "allDay" => 'allDay'


    	];
    }
}
