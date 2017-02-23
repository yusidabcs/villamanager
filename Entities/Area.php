<?php namespace Modules\Villamanager\Entities;

use Modules\Media\Support\Traits\MediaRelation;
use Illuminate\Database\Eloquent\Model;

class Area extends Model{
    use MediaRelation;

    protected $table = 'villamanager__areas';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'villa_id',
        'location',
        'parent_id',
    ];

    public function villa(){
        return $this->hasMany(Villa::class,'villa_id');
    }
}