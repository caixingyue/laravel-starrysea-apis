<?php

namespace Starrysea\Apis;

use Illuminate\Support\ServiceProvider;

class ApisServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Apis', function () {
            return new Apis();
        });
    }
}
