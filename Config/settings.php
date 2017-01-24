<?php
return [

    

    'reservation_type' => [
        'description' => 'Reservation Type',
        'translatable' => false,
        'options' => [
           '1' => 'Booking System &nbsp;',
           '2' => 'Inquiry System',
       ],
       'view' => 'villamanager::fields.radio'
    ],

	'logo' => [
        'description' => 'Logo',
        'view' => 'villamanager::admin.fields.logo',
        'translatable' => false,
    ],
    'booking_percentage' => [
    	'description' => 'Booking percentage',
    	'view'	=> 'text',
    	'translatable' => false
    ],
    'payment_tos' => [
    	'description' => 'Payment Term of Service',
    	'view'	=> 'villamanager::fields.tos',
    	'translatable' => true
    ],

    'check_in_time' => [
        'description' => 'Checkin time to villa',
        'view'  => 'number',
    ],
    'check_out_time' => [
        'description' => 'Checkout time to villa',
        'view'  => 'number',
    ],
    'paypal_sandbox' => [
        'description' => 'Paypal Mode (Use sandbox for testing only)',
        'options' => [
            'true' => 'Sandbox',
            'false' => 'Live',
        ],

        'default' => 1,
        'view'  => 'villamanager::fields.radio',
    ],
    'paypal_client_id' => [
        'description' => 'Paypal Live client id',
        'view'  => 'text',
    ],

    'paypal_secret' => [
        'description' => 'Paypal Live secret',
        'view'  => 'text',
    ],
    'paypal_sandbox_client_id' => [
        'description' => 'Paypal Sandbox client id',
        'view'  => 'text',
    ],

    'paypal_sandbox_secret' => [
        'description' => 'Paypal Sandbox secret',
        'view'  => 'text',
    ],

];