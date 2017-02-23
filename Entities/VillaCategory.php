<?php namespace Modules\Villamanager\Entities;
   
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;

class VillaCategory extends Model {

    use Translatable;
    use MediaRelation;
    protected $table = 'villamanager__villa_categories';
    public $timestamps = false;
    public $translatedAttributes = [
        'name',
        'description'
    ];
    protected $fillable = [
        'name',
        'description'
    ];

    public function villas(){
        return $this->hasMany(Villa::class,'category_id');
    }

}