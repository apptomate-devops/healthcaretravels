<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Helper;
use App\Models\BookingPayments;
use App\Services\Logger;

class ProcessPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payment_id;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 10;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($payment_id)
    {
        $this->payment_id = $payment_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Logger::info('Payment Processing job for payment id: ' . $this->payment_id . ' initiated at ' . now());
            $payment = BookingPayments::find($this->payment_id);
            Helper::process_booking_payment($payment->booking_id, $payment->payment_cycle, $payment->is_owner);
        } catch (Exception $e) {
            error_log($e);
        }
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed()
    {
        $message = 'Payment Processing job for payment id: ' . $this->payment_id . ' failed at ' . now();
        error_log($message);
        Logger::error($message);
    }
}
