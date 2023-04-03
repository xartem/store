<?php

return [
    'providers' => [
        'unitpay' => [
            'public_key' => env('API_KEY', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'),
            'secret_key' => env('SECRET_KEY', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'),
            'sandbox' => env('SANDBOX', true),
            'callback_url' => env('CALLBACK_URL', 'http://localhost:8000/payment/callback'),
        ],
    ],
];
