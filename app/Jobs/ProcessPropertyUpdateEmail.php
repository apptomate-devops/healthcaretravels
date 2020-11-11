<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Helper;
use App\Services\Logger;

class ProcessPropertyUpdateEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 10;
    protected $property_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($property_id)
    {
        $this->property_id = $property_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Helper::handlePropertyUpdateEmail($this->property_id);
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed()
    {
        $message = 'Property update email job with id: ' . $this->property_id . ' failed at ' . now();
        error_log($message);
        Logger::error($message);
    }
}
