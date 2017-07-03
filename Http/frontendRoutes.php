<?php

use Illuminate\Routing\Router;

/** @var Router $router */
if (! App::runningInConsole()) {


    Route::get('language/{lang}',function ($lang){
        Session::set('applocale', $lang);

        return redirect(request('to'));
    });

    $router->get('/grab',function (){


    });

    $router->get('/our-villas', [
        'uses' => 'PublicController@homepage',
        'as' => 'villas.index',
    ]);
    $router->get('/villas/{slug}', [
        'uses' => 'PublicController@uri',
        'as' => 'villas.show',
    ]);

    $router->get('bookings/{id}/export-ics', [
        'as' => 'villamanager.booking.export-ics',
        'uses' => 'BookingController@exportIcs'
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

    $router->get('/villas/{slug}/pdf',[
        'as' => 'villamanager.show.pdf',
        'uses' => 'PublicController@toPdf',
    ]);

    $router->get('areas', [
        'as' => 'villamanager.areas',
        'uses' => 'AreaController@index'
    ]);

    $router->get('users/bookings', [
        'as' => 'users.bookings',
        'uses' => 'BookingController@index'
    ]);

    $router->group(['prefix' => 'villamanagers'],function (Router $router){

        $router->get('check-availability/{id}',[
            'as' => 'api.check_availability',
            'uses'  => 'BookingController@checkAvailability'
        ]);

    });
}
