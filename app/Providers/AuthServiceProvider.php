<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

use App\Models\Passport\AuthCode;
use App\Models\Passport\Client;
use App\Models\Passport\PersonalAccessClient;
use App\Models\Passport\Token;

use App\Models\User;
use App\Models\Brand;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies(); // default already written here

        // same as controller closure function
        Gate::define('update-brand-with-gate', function (User $user, Brand $brand) { 
            return $user->id === $brand->user_id;
        });
        // Gate::define('update-brand-with-gate', [BrandPolicy::class, 'update']); // same as controller

        // for laravel passport
        // if (!$this->app->routesAreCached()) {
        //     Passport::routes();
        // }

        // Passport::useTokenModel(Token::class);
        // Passport::useClientModel(Client::class);
        // Passport::useAuthCodeModel(AuthCode::class);
        // Passport::usePersonalAccessClientModel(PersonalAccessClient::class);

    }
}
