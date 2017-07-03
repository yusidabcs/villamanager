<?php namespace Modules\Villamanager\Entities;

use Illuminate\Database\Eloquent\Model;

class VillaTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['short_description','description','tos','villa_id','locale',
        'meta_title',
        'meta_keyword',
	    'meta_description'
	    ];
    protected $table = 'villamanager__villa_translations';
}
