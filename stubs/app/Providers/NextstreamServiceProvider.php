<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class NextstreamServiceProvider extends ServiceProvider
{
  public function boot()
  {
    Route::group(['middleware' => ['api'], 'prefix' => 'api'], function () {
      $this->loadRoutesFrom(base_path('routes/nextstream.php'));
    });
  }
}
