<?php

namespace Cosapi\Providers;

use Illuminate\Support\ServiceProvider;

class DateRangePickerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../node_modules/daterangepicker/daterangepicker.css' => public_path('../resources/assets/node_modules/daterangepicker/daterangepicker.css'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../../node_modules/daterangepicker/moment.min.js' => public_path('../resources/assets/node_modules/daterangepicker/moment.min.js'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../../node_modules/daterangepicker/daterangepicker.js' => public_path('../resources/assets/node_modules/daterangepicker/daterangepicker.js'),
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
