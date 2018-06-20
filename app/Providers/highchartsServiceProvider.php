<?php

namespace Cosapi\Providers;

use Illuminate\Support\ServiceProvider;

class HighchartsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->publishes([
          __DIR__ . '/../../node_modules/highcharts/' => public_path('../resources/assets/node_modules/highcharts/'),
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
