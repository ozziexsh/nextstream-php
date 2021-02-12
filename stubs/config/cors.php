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

  'paths' => [
    'api/*',
    'sanctum/csrf-cookie',
    'register',
    'login',
    'forgot-password',
    'reset-password',
    'user',
    'user/profile-information',
    'user/password',
    'user/two-factor-authentication',
    'user/two-factor-qr-code',
    'user/confirm-password',
    'user/two-factor-recovery-codes',
    'user/password-confirmation-status',
    'user/profile-photo',
    'user/api-tokens',
    'two-factor-challenge',
    'api-tokens/*',
    'features',
  ],

  'allowed_methods' => ['*'],

  'allowed_origins' => ['*'],

  'allowed_origins_patterns' => [],

  'allowed_headers' => ['*'],

  'exposed_headers' => [],

  'max_age' => 0,

  'supports_credentials' => true,
];
