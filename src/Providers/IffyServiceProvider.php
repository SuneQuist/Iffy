<?php

namespace Iffy\Providers;

use Roots\Acorn\ServiceProvider;
use Iffy\Iffy;

class IffyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Iffy', function () {
            return new Iffy($this->app);
        });

        /*  Make settings accesible */
        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php',
            'iffy'
        );

        /* use the built-in config function */
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->make('Iffy');
    }
}
