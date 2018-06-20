<?php

namespace Cosapi\Providers;

use Illuminate\Support\ServiceProvider;

class ClockPickerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../node_modules/clockpicker/dist' => public_path('../resources/assets/node_modules/clockpicker'),
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
