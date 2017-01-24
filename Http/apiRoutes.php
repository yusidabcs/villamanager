<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->get('villamanagers/checkprice/{id}', ['uses' => 'BookingController@checkprice', 'as' => 'api.villamanger.checkprice']);
$router->get('villamanagers/bookingdate/{id}', ['uses' => 'BookingController@bookingdate', 'as' => 'api.villamanger.bookingdate']);
