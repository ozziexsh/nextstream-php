<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Ozzie\Nextstream\Nextstream;

class NextstreamServiceProvider extends ServiceProvider
{
  public function boot()
  {
    $this->loadRoutesFrom(base_path('routes/nextstream.php'));

    Nextstream::defaultApiTokenPermissions(['read']);
    Nextstream::permissions([
      'create',
      'read',
      'update',
      'delete',
    ]);
  }
}
