<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/villamanager'], function (Router $router) {
    $router->bind('villa', function ($id) {
        return app('Modules\Villamanager\Repositories\VillaRepository')->find($id);
    });
    $router->get('villas', [
        'as' => 'admin.villamanager.villa.index',
        'uses' => 'VillaController@index',
        'middleware' => 'can:villamanager.villas.index'
    ]);
    $router->get('villas/create', [
        'as' => 'admin.villamanager.villa.create',
        'uses' => 'VillaController@create',
        'middleware' => 'can:villamanager.villas.create'
    ]);
    $router->post('villas', [
        'as' => 'admin.villamanager.villa.store',
        'uses' => 'VillaController@store',
        'middleware' => 'can:villamanager.villas.store'
    ]);
    $router->get('villas/{villa}/edit', [
        'as' => 'admin.villamanager.villa.edit',
        'uses' => 'VillaController@edit',
        'middleware' => 'can:villamanager.villas.edit'
    ]);
    $router->put('villas/{villa}', [
        'as' => 'admin.villamanager.villa.update',
        'uses' => 'VillaController@update',
        'middleware' => 'can:villamanager.villas.update'
    ]);
    $router->delete('villas/{villa}', [
        'as' => 'admin.villamanager.villa.destroy',
        'uses' => 'VillaController@destroy',
        'middleware' => 'can:villamanager.villas.destroy'
    ]);
    $router->bind('rate', function ($id) {
        return app('Modules\Villamanager\Repositories\RateRepository')->find($id);
    });
    $router->get('rates', [
        'as' => 'admin.villamanager.rate.index',
        'uses' => 'RateController@index',
        'middleware' => 'can:villamanager.rates.index'
    ]);
    $router->get('rates/{villa_id}/create', [
        'as' => 'admin.villamanager.rate.create',
        'uses' => 'RateController@create',
        'middleware' => 'can:villamanager.rates.create'
    ]);
    $router->post('rates/{villa_id}', [
        'as' => 'admin.villamanager.rate.store',
        'uses' => 'RateController@store',
        'middleware' => 'can:villamanager.rates.store'
    ]);
    $router->get('rates/{rate}/edit', [
        'as' => 'admin.villamanager.rate.edit',
        'uses' => 'RateController@edit',
        'middleware' => 'can:villamanager.rates.edit'
    ]);
    $router->put('rates/{rate}', [
        'as' => 'admin.villamanager.rate.update',
        'uses' => 'RateController@update',
        'middleware' => 'can:villamanager.rates.update'
    ]);
    $router->delete('rates/{rate}', [
        'as' => 'admin.villamanager.rate.destroy',
        'uses' => 'RateController@destroy',
        'middleware' => 'can:villamanager.rates.destroy'
    ]);
    $router->bind('facility', function ($id) {
        return app('Modules\Villamanager\Repositories\FacilityRepository')->find($id);
    });
    $router->get('facilities', [
        'as' => 'admin.villamanager.facility.index',
        'uses' => 'FacilityController@index',
        'middleware' => 'can:villamanager.facilities.index'
    ]);
    $router->get('facilities/create', [
        'as' => 'admin.villamanager.facility.create',
        'uses' => 'FacilityController@create',
        'middleware' => 'can:villamanager.facilities.create'
    ]);
    $router->post('facilities', [
        'as' => 'admin.villamanager.facility.store',
        'uses' => 'FacilityController@store',
        'middleware' => 'can:villamanager.facilities.store'
    ]);
    $router->get('facilities/{facility}/edit', [
        'as' => 'admin.villamanager.facility.edit',
        'uses' => 'FacilityController@edit',
        'middleware' => 'can:villamanager.facilities.edit'
    ]);
    $router->put('facilities/{facility}', [
        'as' => 'admin.villamanager.facility.update',
        'uses' => 'FacilityController@update',
        'middleware' => 'can:villamanager.facilities.update'
    ]);
    $router->delete('facilities/{facility}', [
        'as' => 'admin.villamanager.facility.destroy',
        'uses' => 'FacilityController@destroy',
        'middleware' => 'can:villamanager.facilities.destroy'
    ]);
    $router->bind('image', function ($id) {
        return app('Modules\Villamanager\Repositories\ImageRepository')->find($id);
    });
    $router->get('villas/{id}/images', [
        'as' => 'admin.villamanager.image.index',
        'uses' => 'ImageController@index',
        'middleware' => 'can:villamanager.images.index'
    ]);
    $router->get('images/create', [
        'as' => 'admin.villamanager.image.create',
        'uses' => 'ImageController@create',
        'middleware' => 'can:villamanager.images.create'
    ]);
    $router->post('villas/{id}/images', [
        'as' => 'admin.villamanager.image.store',
        'uses' => 'ImageController@store',
        'middleware' => 'can:villamanager.images.store'
    ]);

    $router->get('villas/{id}/images/{id2}/thumbnail', [
        'as' => 'admin.villamanager.image.thumbnail',
        'uses' => 'ImageController@thumbnail',
    ]);
    $router->get('images/{image}/edit', [
        'as' => 'admin.villamanager.image.edit',
        'uses' => 'ImageController@edit',
        'middleware' => 'can:villamanager.images.edit'
    ]);
    $router->put('images/{image}', [
        'as' => 'admin.villamanager.image.update',
        'uses' => 'ImageController@update',
        'middleware' => 'can:villamanager.images.update'
    ]);

    $router->bind('media', function ($id) {
        return app(\Modules\Media\Repositories\FileRepository::class)->find($id);
    });
    $router->delete('images/{media}', [
        'as' => 'admin.villamanager.image.destroy',
        'uses' => 'ImageController@destroy',
        'middleware' => 'can:villamanager.images.destroy'
    ]);
// append


    $router->bind('booking', function ($id) {
        return app(\Modules\Villamanager\Repositories\BookingRepository::class)->find($id);
    });

    $router->get('bookings', [
        'as' => 'admin.villamanager.booking.index',
        'uses' => 'BookingController@index',
        'middleware' => 'can:villamanager.bookings.index'
    ]);

    $router->post('bookings', [
        'as' => 'admin.villamanager.booking.store',
        'uses' => 'BookingController@store',
        'middleware' => 'can:villamanager.bookings.store'
    ]);

    $router->get('bookings/{id}', [
        'as' => 'admin.villamanager.booking.show',
        'uses' => 'BookingController@show',
        'middleware' => 'can:villamanager.bookings.show'
    ]);
    $router->get('bookings/{id}/edit', [
        'as' => 'admin.villamanager.booking.edit',
        'uses' => 'BookingController@edit',
        'middleware' => 'can:villamanager.bookings.edit'
    ]);

    $router->put('bookings/{id}', [
        'as' => 'admin.villamanager.booking.update',
        'uses' => 'BookingController@update',
        'middleware' => 'can:villamanager.bookings.update'
    ]);


    $router->bind('inquiry', function ($id) {
        return app(\Modules\Villamanager\Repositories\InquiryRepository::class)->find($id);
    });

    $router->get('inquiries', [
        'as' => 'admin.villamanager.inquiry.index',
        'uses' => 'InquiryController@index',
        'middleware' => 'can:villamanager.inquiries.index'
    ]);

    $router->post('inquiries', [
        'as' => 'admin.villamanager.inquiry.store',
        'uses' => 'BookingController@store',
        'middleware' => 'can:villamanager.inquiries.store'
    ]);

    $router->get('inquiries/{id}', [
        'as' => 'admin.villamanager.inquiry.show',
        'uses' => 'BookingController@show',
        'middleware' => 'can:villamanager.inquiries.show'
    ]);
    $router->get('inquiries/{id}/edit', [
        'as' => 'admin.villamanager.inquiry.edit',
        'uses' => 'BookingController@edit',
        'middleware' => 'can:villamanager.inquiries.edit'
    ]);

    $router->put('inquiries/{id}', [
        'as' => 'admin.villamanager.inquiry.update',
        'uses' => 'BookingController@update',
        'middleware' => 'can:villamanager.inquiries.update'
    ]);


    $router->bind('discount', function ($id) {
        return app(\Modules\Villamanager\Repositories\DiscountRepository::class)->find($id);
    });

    $router->get('discounts', [
        'as' => 'admin.villamanager.discount.index',
        'uses' => 'DiscountController@index',
        'middleware' => 'can:villamanager.discounts.index'
    ]);

    $router->get('discounts/create', [
        'as' => 'admin.villamanager.discount.create',
        'uses' => 'DiscountController@create',
        'middleware' => 'can:villamanager.discounts.create'
    ]);

    $router->post('discounts', [
        'as' => 'admin.villamanager.discount.store',
        'uses' => 'DiscountController@store',
        'middleware' => 'can:villamanager.discounts.store'
    ]);

    $router->get('discounts/{discount}', [
        'as' => 'admin.villamanager.discount.show',
        'uses' => 'DiscountController@show',
        'middleware' => 'can:villamanager.discounts.show'
    ]);

    $router->get('discounts/{discount}/edit', [
        'as' => 'admin.villamanager.discount.edit',
        'uses' => 'DiscountController@edit',
        'middleware' => 'can:villamanager.discounts.edit'
    ]);

    $router->put('discounts/{discount}', [
        'as' => 'admin.villamanager.discount.update',
        'uses' => 'DiscountController@update',
        'middleware' => 'can:villamanager.discounts.update'
    ]);

    $router->delete('discounts/{discount}', [
        'as' => 'admin.villamanager.discount.destroy',
        'uses' => 'DiscountController@destroy',
        'middleware' => 'can:villamanager.discounts.destroy'
    ]);


    $router->bind('disabledate', function ($id) {
        return app(\Modules\Villamanager\Repositories\DisableDateRepository::class)->find($id);
    });

    $router->post('disabledates', [
        'as' => 'admin.villamanager.disabledate.store',
        'uses' => 'DisableDateController@store',
        'middleware' => 'can:villamanager.disabledates.store'
    ]);

    $router->get('disabledates', [
        'as' => 'admin.villamanager.disabledate.index',
        'uses' => 'DisableDateController@index',
        'middleware' => 'can:villamanager.disabledates.index'
    ]);
    $router->delete('disabledates/{disabledate}', [
        'as' => 'admin.villamanager.disabledate.destroy',
        'uses' => 'DisableDateController@destroy',
        'middleware' => 'can:villamanager.disabledates.destroy'
    ]);


    $router->bind('area', function ($id) {
        return app(\Modules\Villamanager\Repositories\AreaRepository::class)->find($id);
    });

    $router->get('areas', [
        'as' => 'admin.villamanager.area.index',
        'uses' => 'AreaController@index',
        'middleware' => 'can:villamanager.areas.index'
    ]);

    $router->post('areas', [
        'as' => 'admin.villamanager.area.store',
        'uses' => 'AreaController@store',
        'middleware' => 'can:villamanager.areas.store'
    ]);

    $router->get('areas/create', [
        'as' => 'admin.villamanager.area.create',
        'uses' => 'AreaController@create',
        'middleware' => 'can:villamanager.areas.create'
    ]);

    $router->get('areas/{area}/edit', [
        'as' => 'admin.villamanager.area.edit',
        'uses' => 'AreaController@edit',
        'middleware' => 'can:villamanager.areas.edit'
    ]);

    $router->put('areas/{area}', [
        'as' => 'admin.villamanager.area.update',
        'uses' => 'AreaController@update',
        'middleware' => 'can:villamanager.areas.update'
    ]);

    $router->delete('areas/{area}', [
        'as' => 'admin.villamanager.area.destroy',
        'uses' => 'AreaController@destroy',
        'middleware' => 'can:villamanager.areas.destroy'
    ]);

});
