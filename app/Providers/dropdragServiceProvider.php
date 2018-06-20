<?php

namespace Cosapi\Providers;

use Illuminate\Support\ServiceProvider;

class DropdragServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
          __DIR__ . '/../../vendor/almasaeed2010/adminlte/bower_components/jquery-ui/' => public_path('../resources/assets/vendor/drop-drag/jquery-ui'),
      ], 'public');
        $this->publishes([
          __DIR__ . '/../../vendor/almasaeed2010/adminlte/dist/js/pages/' => public_path('../resources/assets/vendor/drop-drag/'),
      ], 'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
