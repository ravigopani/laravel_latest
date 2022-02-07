<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Support\DripEmailer;
use App\Models\User;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send {user}';
    // protected $signature = 'mail:send {user} {--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a marketing email to a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(DripEmailer $drip)
    {
        // return 0;
        $drip->send(User::find($this->argument('user')));
    }
}
