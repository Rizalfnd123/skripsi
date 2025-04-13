<?php

return [


    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],


    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'mitra' => [
            'driver' => 'session',
            'provider' => 'mitras',
        ],
        'dosen' => [
            'driver' => 'session',
            'provider' => 'dosens',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
        'mitras' => [
            'driver' => 'eloquent',
            'model' => App\Models\Mitra::class,
        ],
        'dosens' => [
            'driver' => 'eloquent',
            'model' => App\Models\Dosen::class,
        ],
    ],


    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],


    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
