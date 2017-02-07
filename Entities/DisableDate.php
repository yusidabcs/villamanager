<?php namespace Modules\Villamanager\Entities;
   
use Illuminate\Database\Eloquent\Model;

class DisableDate extends Model {

    protected $table = 'villamanager__disable_dates';
    protected $fillable = [
        'date',
        'villa_id',
        'reason'
    ];
    public $timestamps = false;

    public function villa()
    {
        return $this->belongsTo(Villa::class, 'villa_id');
    }

    public function fullcalender(){
        return [
            'id' => $this->id,
            'type' => 'disable_date',
            'title' => ($this->villa ? $this->villa->name : '').' | '.$this->reason,
            'start' => $this->date.' 14:00:00',
            'color' => '#001f3f',
            'editable' => true,
            'startEditable' => true,
            'resourceEditable' => true
        ];
    }
}