<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'prayer' => [
        'provider' => env('PRAYER_API_PROVIDER', 'aladhan'),
        'url' => env('PRAYER_API_URL', 'https://api.aladhan.com/v1'),
        'latitude' => env('PRAYER_LOCATION_LAT', ' -6.914744'),
        'longitude' => env('PRAYER_LOCATION_LON', '107.609810'),
        'timezone' => env('PRAYER_TIMEZONE', 'Asia/Jakarta'),
        'sync_time' => env('PRAYER_SYNC_TIME', '00:05'),
    ],

];
