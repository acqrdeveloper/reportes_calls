<?php

namespace Cosapi\Providers;

use Illuminate\Support\ServiceProvider;

class PushjsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
          __DIR__ . '/../../node_modules/push.js/bin' => public_path('../resources/assets/node_modules/push.js/'),
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
