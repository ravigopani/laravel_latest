<?php

namespace App\Listeners;

use App\Events\BrandCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBrandNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\BrandCreated  $event
     * @return void
     */
    public function handle(BrandCreated $event)
    {
        info('notification sent');
    }
}
