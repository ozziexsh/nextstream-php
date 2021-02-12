<?php

namespace Ozzie\Nextstream;

use Illuminate\Support\ServiceProvider;

class NextstreamServiceProvider extends ServiceProvider
{
  public function boot()
  {
    $this->configurePublishing();
    $this->configureCommands();
  }

  public function configurePublishing()
  {
    if (!$this->app->runningInConsole()) {
      return;
    }

    $this->publishes([
      __DIR__ . '/../stubs' => base_path(),
    ]);
  }

  /**
   * Configure the commands offered by the application.
   *
   * @return void
   */
  protected function configureCommands()
  {
    if (!$this->app->runningInConsole()) {
      return;
    }

    $this->commands([
      Console\InstallCommand::class,
    ]);
  }
}
