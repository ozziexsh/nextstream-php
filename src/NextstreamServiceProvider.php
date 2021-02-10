<?php

namespace Ozzie\Nextstream;

use Illuminate\Support\ServiceProvider;

class NextstreamServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->app->register('App\Providers\NextstreamServiceProvider');
    $this->app['config']->set('cors.paths', array_merge(config('cors.paths'), [
      'api/*',
      'sanctum/csrf-cookie',
      'register',
      'login',
      'forgot-password',
      'reset-password',
      'user/profile-information',
      'user/password',
      'user/two-factor-authentication',
      'user/two-factor-qr-code',
      'user/confirm-password',
      'user/two-factor-recovery-codes',
      'user/password-confirmation-status',
      'two-factor-challenge',
      'user/profile-photo',
      'user',
    ]));
    $this->app['config']->set('cors.supports_credentials', true);
  }

  public function boot()
  {
    if ($this->app->runningInConsole()) {
      $this->publishes([
        __DIR__ . '/../stubs/config/jetstream.php' => config_path('jetstream.php'),
        __DIR__ . '/../stubs/routes/nextstream.php' => base_path('routes/nextstream.php'),
        __DIR__ . '/../stubs/app/Http/Controllers' => app_path('Http/Controllers/Nextstream'),
        __DIR__ . '/../stubs/app/Providers/NextstreamServiceProvider.php' => app_path('Providers/NextstreamServiceProvider.php'),
      ]);
    }
  }
}
