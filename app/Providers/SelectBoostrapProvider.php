<?php

namespace Cosapi\Providers;

use Illuminate\Support\ServiceProvider;

class SelectBoostrapProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../node_modules/bootstrap-select/dist' => public_path('../resources/assets/node_modules/bootstrap-select'),
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
