<?php

use Illuminate\Routing\Router;

/** @var Router $router */
if (! App::runningInConsole()) {
    

    /*$router->get('/villas', [
        'uses' => 'PublicController@homepage',
        'as' => 'villas.index',
    ]);*/

    $router->get('/villas/{slug}', [
        'uses' => 'PublicController@uri',
        'as' => 'villas.show',
    ]);

    $router->post('bookings/{id}/confirmation', [
        'as' => 'villamanager.bookings.confirmation',
        'uses' => 'BookingController@confirmation',
    ]);

    $router->get('/bookings/{id}', [
        'uses' => 'BookingController@show',
        'as' => 'villamanager.bookings.show',
    ]);

    $router->post('bookings/{id}', [
        'as' => 'villamanager.bookings.store',
        'uses' => 'BookingController@store',
    ]);

    $router->get('bookings/payment/{booking_number}', [
        'as' => 'villamanager.bookings.payment',
        'uses' => 'BookingController@payment',
    ]);

    $router->get('bookings/payment/{booking_number}/paywithpaypal', [
        'as' => 'villamanager.bookings.paywithpaypal',
        'uses' => 'BookingController@paywithpaypal',
    ]);

    $router->get('bookings/payment/{booking_number}/done', [
        'as' => 'villamanager.bookings.paypalsuccess',
        'uses' => 'BookingController@paypalsuccess',
    ]);

    $router->get('bookings/payment/{booking_number}/cancel', [
        'as' => 'villamanager.bookings.paypalcancel',
        'uses' => 'BookingController@paypalcancel',
    ]);

    

    

}
