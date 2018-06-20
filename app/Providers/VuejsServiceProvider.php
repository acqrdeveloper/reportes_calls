<?php

namespace Cosapi\Providers;

use Illuminate\Support\ServiceProvider;

class VuejsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../node_modules/vue/dist' => public_path('../resources/assets/node_modules/vue'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../../node_modules/vue-resource/dist' => public_path('../resources/assets/node_modules/vue-resource'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../../node_modules/vue-select/dist' => public_path('../resources/assets/node_modules/vue-select'),
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
