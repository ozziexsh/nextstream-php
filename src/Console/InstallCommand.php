<?php

namespace Ozzie\Nextstream\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
  protected $signature = 'nextstream:install';

  protected $description = 'Perform the first-time setup of Nextstream';

  public function handle()
  {
    (new Process(['composer', 'require', 'laravel/sanctum'], base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
      ->setTimeout(null)
      ->run(function ($type, $output) {
        $this->output->write($output);
      });
    $this->callSilent('vendor:publish', ['--provider' => 'Laravel\Fortify\FortifyServiceProvider', '--force' => true]);
    $this->callSilent('vendor:publish', ['--provider' => 'Laravel\Sanctum\SanctumServiceProvider', '--force' => true]);
    $this->callSilent('vendor:publish', ['--provider' => 'Ozzie\Nextstream\NextstreamServiceProvider', '--force' => true]);

    $this->installServiceProviderAfter('RouteServiceProvider', 'FortifyServiceProvider');
    $this->installServiceProviderAfter('FortifyServiceProvider', 'NextstreamServiceProvider');

    $this->configureSession();

    $this->replaceInFile('auth:api', 'auth:sanctum', base_path('routes/api.php'));
  }

  /**
   * Configure the session driver for Nextstream.
   *
   * @return void
   */
  protected function configureSession()
  {
    if (!class_exists('CreateSessionsTable')) {
      try {
        $this->call('session:table');
      } catch (Exception $e) {
        //
      }
    }

    $this->replaceInFile("'SESSION_DRIVER', 'file'", "'SESSION_DRIVER', 'database'", config_path('session.php'));
    $this->replaceInFile('SESSION_DRIVER=file', 'SESSION_DRIVER=database', base_path('.env'));
    $this->replaceInFile('SESSION_DRIVER=file', 'SESSION_DRIVER=database', base_path('.env.example'));
  }

  /**
   * Install the service provider in the application configuration file.
   *
   * @param  string  $after
   * @param  string  $name
   * @return void
   */
  protected function installServiceProviderAfter($after, $name)
  {
    if (!Str::contains($appConfig = file_get_contents(config_path('app.php')), 'App\\Providers\\' . $name . '::class')) {
      file_put_contents(config_path('app.php'), str_replace(
        'App\\Providers\\' . $after . '::class,',
        'App\\Providers\\' . $after . '::class,' . PHP_EOL . '        App\\Providers\\' . $name . '::class,',
        $appConfig
      ));
    }
  }

  /**
   * Replace a given string within a given file.
   *
   * @param  string  $search
   * @param  string  $replace
   * @param  string  $path
   * @return void
   */
  protected function replaceInFile($search, $replace, $path)
  {
    file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
  }
}
