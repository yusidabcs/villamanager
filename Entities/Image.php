<?php namespace Modules\Villamanager\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $table = 'villamanager__images';
    public $translatedAttributes = [];
    protected $fillable = [];
}
