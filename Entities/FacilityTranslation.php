<?php namespace Modules\Villamanager\Entities;

use Illuminate\Database\Eloquent\Model;

class FacilityTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'name',
	    'facility_id',
	    'locale'
    ];
    protected $table = 'villamanager__facility_translations';
}
