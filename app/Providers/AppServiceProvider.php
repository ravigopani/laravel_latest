<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // marcro functinon use after call of redirect function
        Response::macro('caps', function ($value) {
            return Response::make(strtoupper($value));
        });

        View::share('key', 'value'); // use for common share data for all view

        // Blade::withoutDoubleEncoding(); // disable double encoding, 
        // Blade::component('package-alert', Alert::class); //you will need to manually register your component class and its HTML tag alias
        // <x-package-alert/> use above alias as this tag
        
    }
}
