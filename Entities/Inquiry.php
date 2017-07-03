<?php
namespace Modules\Villamanager\Entities;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $table = 'villamanager__inquiries';

    protected $fillable = [
        'inquiry_number',
        'villa_id',

        'check_in',
        'check_out',
        'adult_guest',
        'child_guest',
        'child_age',
        'airport_transfer',
        'arival_flight_number',
        'arival_flight_date',
        'departure_flight_date',
        'departure_flight_number',

        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'country',
    ];
}