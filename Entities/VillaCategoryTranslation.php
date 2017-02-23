<?php namespace Modules\Villamanager\Entities;
   
use Illuminate\Database\Eloquent\Model;

class VillaCategoryTranslation extends Model {

    public $timestamps = false;
    protected $table = 'villamanager__villa_category_translations';
    protected $fillable = [
        'name',
        'description'
    ];

}