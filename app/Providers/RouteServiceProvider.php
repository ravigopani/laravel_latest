<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use App\Models\User;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        // now always `id` parameter should be pass as regualar expression
        // Route::pattern('id', '[0-9]+');

        // Explicit Binding [ Route model bindings ]
        // Route::model('user', User::class);
        // Custom Explicit Binding [ Route model bindings ]
        Route::bind('custom_user', function ($value) {
            return User::where('name', $value)->firstOrFail();
        });

        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            /***** added custom route file *****/
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/my_routes.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });

        // RateLimiter::for('global', function (Request $request) {
        //     return Limit::perMinute(1000);
        // });

        // RateLimiter::for('global', function (Request $request) {
        //     return Limit::perMinute(1000)->response(function () {
        //         return response('Custom response...', 429);
        //     });
        // });

        // RateLimiter::for('uploads', function (Request $request) {
        //     return $request->user()->vipCustomer()
        //         ? Limit::none()
        //         : Limit::perMinute(100);
        // });

        // Segmenting Rate Limits
        // RateLimiter::for('uploads', function (Request $request) {
        //     return $request->user()->vipCustomer()
        //         ? Limit::none()
        //         : Limit::perMinute(100)->by($request->ip());
        // });

        // RateLimiter::for('uploads', function (Request $request) {
        //     return $request->user()
        //     ? Limit::perMinute(100)->by($request->user()->id)
        //     : Limit::perMinute(10)->by($request->ip());
        // });

        // Multiple Rate Limits
        // RateLimiter::for('login', function (Request $request) {
        //     return [
        //         Limit::perMinute(500),
        //         Limit::perMinute(3)->by($request->input('email')),
        //     ];
        // });
    }
}
