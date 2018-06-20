<?php

namespace Cosapi\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::extend(function ($value) {
            return preg_replace('/\@define(.+)/', '<?php ${1}; ?>', $value);
        });

        Carbon::setLocale('es');
        Date::setLocale('es');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
