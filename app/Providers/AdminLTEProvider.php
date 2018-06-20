<?php

namespace Cosapi\Providers;

use Illuminate\Support\ServiceProvider;

class AdminLTEProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->publishes([
          __DIR__ . '/../../vendor/almasaeed2010/adminlte/dist' => public_path('../resources/assets/vendor/adminlte/dist/'),
      ], 'public');

      $this->publishes([
          __DIR__ . '/../../vendor/almasaeed2010/adminlte/bower_components/bootstrap/dist' => public_path('../resources/assets/vendor/adminlte/plugins/bootstrap/dist/'),
      ], 'public');

      $this->publishes([
          __DIR__ . '/../../vendor/almasaeed2010/adminlte/bower_components/font-awesome/css' => public_path('../resources/assets/vendor/adminlte/plugins/font-awesome/css/'),
      ], 'public');

      $this->publishes([
          __DIR__ . '/../../vendor/almasaeed2010/adminlte/bower_components/font-awesome/fonts' => public_path('../resources/assets/vendor/adminlte/plugins/font-awesome/fonts/'),
      ], 'public');

      $this->publishes([
          __DIR__ . '/../../vendor/almasaeed2010/adminlte/bower_components/Ionicons/css' => public_path('../resources/assets/vendor/adminlte/plugins/Ionicons/css/'),
      ], 'public');

      $this->publishes([
          __DIR__ . '/../../vendor/almasaeed2010/adminlte/bower_components/Ionicons/fonts' => public_path('../resources/assets/vendor/adminlte/plugins/Ionicons/fonts/'),
      ], 'public');

      $this->publishes([
          __DIR__ . '/../../vendor/almasaeed2010/adminlte/bower_components/jquery/dist' => public_path('../resources/assets/vendor/adminlte/plugins/jquery/dist/'),
      ], 'public');

      $this->publishes([
          __DIR__ . '/../../vendor/almasaeed2010/adminlte/bower_components/fastclick/lib' => public_path('../resources/assets/vendor/adminlte/plugins/fastclick/lib/'),
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
