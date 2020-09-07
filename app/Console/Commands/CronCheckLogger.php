<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Logger;

class CronCheckLogger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:log-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking if cron are working';

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
     * @return mixed
     */
    public function handle()
    {
        Logger::info('Cron jobs are running fine. Checked at: ' . date('F j, Y, g:i a'));
    }
}
