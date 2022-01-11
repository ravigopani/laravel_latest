<?php

namespace App\Providers;

use App\Composers\ProfileComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // Using class based composers...
        View::composer('test_composer', ProfileComposer::class);

        // Using closure based composers...
        View::composer('test_composer', function ($view) {
            $view->with('count', 'this value is from "ViewServiceProvider"');
        });

        // View::composer(
        //     ['profile', 'dashboard'],
        //     MultiComposer::class
        // );

        // View::creator('profile', ProfileCreator::class); //
        // View "creators" are very similar to view composers; however, they are executed immediately after the view is instantiated instead of waiting until the view is about to render.
    }
}