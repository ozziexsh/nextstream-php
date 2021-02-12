<?php

use Ozzie\Nextstream\Features;

return [
  'frontend_url' => env('FRONTEND_URL', 'http://localhost:3000'),

  /*
    |--------------------------------------------------------------------------
    | Nextstream Features
    |--------------------------------------------------------------------------
    |
    | To enable a feature, uncomment the line
    | To disable a feature, comment the line
    | 
    */

  'features' => [
    // Features::termsAndPrivacyPolicy(),
    // Features::profilePhotos(),
    // Features::api(),
    // Features::teams(['invitations' => true]),
    Features::accountDeletion(),
  ],
];
