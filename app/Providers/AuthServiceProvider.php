<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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


    }
}
