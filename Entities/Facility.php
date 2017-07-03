<?php namespace Modules\Villamanager\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use Translatable;

    protected $table = 'villamanager__facilities';
    public $translatedAttributes = [
    'name',
    'facility_id',
    'locale'
    ];
    protected $fillable = [
        'type',
    	'icon',
        'key',

    	'name',
	    'facility_id',
	    'locale'
    ];


    
}
