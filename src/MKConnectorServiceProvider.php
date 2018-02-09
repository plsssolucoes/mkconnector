<?php

namespace PLSS\MKConnector;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
	    //registro de facades mkconnector
	    $this->app->singleton('mkconnector', function() {
		    return new MKConnector();
	    });

    }
}

