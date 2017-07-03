<?php

return [

    'villamanager.villas' => [
        'index' => 'villamanager::villas.list resource',
        'create' => 'villamanager::villas.create resource',
        'edit' => 'villamanager::villas.edit resource',
        'destroy' => 'villamanager::villas.destroy resource',
        'thumbnail' => 'villamanager::villas.destroy resource',
        'copy' => 'villamanager::villas.copy resource',
    ],
    'villamanager.rates' => [
        'index' => 'villamanager::rates.list resource',
        'create' => 'villamanager::rates.create resource',
        'edit' => 'villamanager::rates.edit resource',
        'destroy' => 'villamanager::rates.destroy resource',
        'thumbnail' => 'villamanager::rates.destroy resource',
    ],
    'villamanager.facilities' => [
        'index' => 'villamanager::facilities.list resource',
        'create' => 'villamanager::facilities.create resource',
        'edit' => 'villamanager::facilities.edit resource',
        'destroy' => 'villamanager::facilities.destroy resource',
    ],
    'villamanager.images' => [
        'index' => 'villamanager::images.list resource',
        'create' => 'villamanager::images.create resource',
        'edit' => 'villamanager::images.edit resource',
        'update' => 'villamanager::images.edit resource',
        'destroy' => 'villamanager::images.destroy resource',
    ],

    'villamanager.bookings' => [
        'index' => 'villamanager::bookings.list resource',
        'create' => 'villamanager::bookings.create resource',
        'edit' => 'villamanager::bookings.edit resource',
        'destroy' => 'villamanager::bookings.destroy resource',
    ],

    'villamanager.inquiries' => [
        'index' => 'villamanager::inquiries.list resource',
        'create' => 'villamanager::inquiries.create resource',
        'edit' => 'villamanager::inquiries.edit resource',
        'destroy' => 'villamanager::inquiries.destroy resource',
    ],

    'villamanager.discounts' => [
        'index' => 'villamanager::discounts.list resource',
        'create' => 'villamanager::discounts.create resource',
        'edit' => 'villamanager::discounts.edit resource',
        'destroy' => 'villamanager::discounts.destroy resource',
    ],

    'villamanager.disabledates' => [
        'index' => 'villamanager::disabledates.list resource',
        'create' => 'villamanager::disabledates.create resource',
        'edit' => 'villamanager::disabledates.edit resource',
        'destroy' => 'villamanager::disabledates.destroy resource',
    ],

    'villamanager.areas' => [
        'index' => 'villamanager::areas.list resource',
        'create' => 'villamanager::areas.create resource',
        'edit' => 'villamanager::areas.edit resource',
        'destroy' => 'villamanager::areas.destroy resource',
    ],
    'villamanager.categories' => [
        'index' => 'villamanager::categories.list resource',
        'create' => 'villamanager::categories.create resource',
        'edit' => 'villamanager::categories.edit resource',
        'destroy' => 'villamanager::categories.destroy resource',
    ],

    'villamanager.reports' => [
        'index' => 'villamanager::reports.list resource',
    ],




];
