<?php

return [
    'default_provider' => env('DEFAULT_EXCHANGE_RATES_PROVIDER'),
    'default_code' => 'TRY',
    'allowed_codes'   => [
        'EUR',
        'GBP',
        'JPY',
        'SEK',
        'USD'
    ]
];
