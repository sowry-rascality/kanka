<?php

return [
    'fraud_detection' => env('APP_FRAUD_DETECTION', false),
    'owlbear' => [
        'eur' => [
            'monthly' => env('STRIPE_OWLBEAR_EUR'),
            'yearly' => env('STRIPE_OWLBEAR_EUR_YEARLY'),
        ],
        'usd' => [
            'monthly' => env('STRIPE_OWLBEAR_USD'),
            'yearly' => env('STRIPE_OWLBEAR_USD_YEARLY')
        ],
        'monthly' => [
            env('STRIPE_OWLBEAR_EUR'),
            env('STRIPE_OWLBEAR_USD'),
        ],
        'yearly' => [
            env('STRIPE_OWLBEAR_EUR_YEARLY'),
            env('STRIPE_OWLBEAR_USD_YEARLY'),
        ],
    ],
    'wyvern' => [
        'eur' => [
            'monthly' => env('STRIPE_WYVERN_EUR'),
            'yearly' => env('STRIPE_WYVERN_EUR_YEARLY'),
        ],
        'usd' => [
            'monthly' => env('STRIPE_WYVERN_USD'),
            'yearly' => env('STRIPE_WYVERN_USD_YEARLY')
        ],
        'monthly' => [
            env('STRIPE_WYVERN_EUR'),
            env('STRIPE_WYVERN_USD'),
        ],
        'yearly' => [
            env('STRIPE_WYVERN_EUR_YEARLY'),
            env('STRIPE_WYVERN_USD_YEARLY'),
        ],
    ],
    'elemental' => [
        'eur' => [
            'monthly' => env('STRIPE_ELEMENTAL_EUR'),
            'yearly' => env('STRIPE_ELEMENTAL_EUR_YEARLY'),
        ],
        'usd' => [
            'monthly' => env('STRIPE_ELEMENTAL_USD'),
            'yearly' => env('STRIPE_ELEMENTAL_USD_YEARLY')
        ],
        'monthly' => [
            env('STRIPE_ELEMENTAL_EUR'),
            env('STRIPE_ELEMENTAL_USD'),
        ],
        'yearly' => [
            env('STRIPE_ELEMENTAL_EUR_YEARLY'),
            env('STRIPE_ELEMENTAL_USD_YEARLY'),
        ],
    ],
];
