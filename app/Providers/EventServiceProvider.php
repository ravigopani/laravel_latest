<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\BrandCreated;
use App\Listeners\SendBrandNotification;

use App\Models\Brand;
use App\Observers\BrandObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Brand::observe(BrandObserver::class);

        Event::listen(
            BrandCreated::class,
            [SendBrandNotification::class, 'handle']
        );

        // Event::listen(function (BrandCreated $event) {
        // });

        // Queueable Anonymous Event Listeners
        // Event::listen(queueable(function (BrandCreated $event) {
        // }));
        // Event::listen(queueable(function (BrandCreated $event) {
        // })->catch(function (BrandCreated $event, Throwable $e) {
        //     // The queued listener failed...
        // }));
    }
}
