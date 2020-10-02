<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Helper;
use App\Services\Logger;

class ProcessMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $number;
    protected $message;
    protected $booking_id;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($number, $message, $booking_id, $type)
    {
        $this->number = $number;
        $this->message = $message;
        $this->booking_id = $booking_id;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Helper::send_message($this->number, $this->message, $this->booking_id, $this->type);
        } catch (Exception $e) {
            error_log($e);
            Logger::error($e);
        }
    }

    public function failed()
    {
        $message = "send message job fail for booking {$this->booking_id}";
        error_log($message);
        Logger::error($message);
    }
}
