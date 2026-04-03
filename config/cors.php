<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost',
        'http://127.0.0.1',
        'http://172.20.10.3',
        // Add Flutter debug origin if different from above
    ],

    'allowed_origins_patterns' => [
        '#^http://172\.20\.10\.\d+:[0-9]+$#',  // Flutter debug bridge
        '#^http://localhost:[0-9]+$#',
        '#^http://127\.0\.0\.1:[0-9]+$#',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,  // Enable for stateful API requests

];
