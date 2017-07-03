<?php
/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 3/30/17
 * Time: 1:59 PM
 */

namespace Modules\Villamanager\Entities;


use Illuminate\Database\Eloquent\Model;

class Tripadvisor extends Model
{
    protected $table = 'villamanager__tripadvisors';
    public $timestamps = false;

    protected $fillable = [
        'villa_id',
        'url'
        ];
}