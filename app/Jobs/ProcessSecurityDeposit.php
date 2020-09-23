<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Helper;
use App\Services\Logger;

class ProcessSecurityDeposit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 10;
    protected $booking_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($booking_id)
    {
        $this->booking_id = $booking_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Helper::setConstantsHelper();
        Helper::processSecurityDepositForBooking($this->booking_id);
    }

        /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed()
    {
        $message = 'Deposit Processing job for booking id: ' . $this->booking_id . ' failed at ' . now();
        error_log($message);
        Logger::error($message);
    }
}
