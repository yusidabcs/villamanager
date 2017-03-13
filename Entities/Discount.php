<?php namespace Modules\Villamanager\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Discount extends Model {

    protected $table = 'villamanager__discounts';

    protected $fillable = [
        'code',
    	'type',
        'discount',
    	'total',
	    'claim',
	    'minimumPayment',
        'start_date',
        'end_date',
        'villa_id'
    ];

    public function scopeActive($query){
        return $query->whereRaw('claim <= `total`')
            ->whereRaw('(CURRENT_DATE between start_date and end_date )');
    }

    public function villas(){
        $rs = [];
        foreach (json_decode($this->villa_id) as $villa_id){
            $rs[] = Villa::find($villa_id);
        }
        return $rs;
    }
}