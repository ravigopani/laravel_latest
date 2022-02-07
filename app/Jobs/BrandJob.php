<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class BrandJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $brand;
    public function __construct($brand)
    {
        $this->brand = $brand;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info($this->brand);
    }

    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
    }
}
