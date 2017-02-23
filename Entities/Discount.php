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

}