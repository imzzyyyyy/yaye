<?php

return [

    'defaults' => [
        'guard' => 'web', // Default guard
        'passwords' => 'users', // Default passwords
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'admins', // Set to 'admins' to use the 'admins' provider
        ],
        'users' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
