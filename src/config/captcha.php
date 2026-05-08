<?php
return [
    'driver' => env('CAPTCHA_DRIVER', 'fake'),

    'recaptcha' => [
        'site_key' => env('GOOGLE_RECAPTCHA_SITE_KEY', ''),
        'secret_key' => env('GOOGLE_RECAPTCHA_SECRET_KEY', ''),
    ],

    'recaptcha_enterprise' => [
        'site_key' => env('GOOGLE_RECAPTCHA_SITE_KEY', ''),
        'api_key' => env('GOOGLE_RECAPTCHA_API_KEY', ''),
        'project_id' => env('GOOGLE_RECAPTCHA_PROJECT_ID', ''),
    ],

    'turnstile' => [
        'site_key' => env('CLOUDFLARE_TURNSTILE_SITE_KEY', ''),
        'secret_key' => env('CLOUDFLARE_TURNSTILE_SECRET_KEY', ''),
    ],
];