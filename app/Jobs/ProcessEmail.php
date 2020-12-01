<?php

namespace App\Jobs;

use App\Http\Controllers\ConstantsController;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Services\Logger;
use Helper;

class ProcessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $to;
    protected $view;
    protected $data;
    protected $subject;
    protected $bookingId;
    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 3;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $view, $subject, $data, $bookingId)
    {
        $this->to = $to;
        $this->view = $view;
        $this->subject = $subject;
        $this->data = $data;
        $this->bookingId = $bookingId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Helper::handleBookingEmails($this->to, $this->subject, $this->view, $this->data, $this->bookingId);
    }

    public function failed()
    {
        $toEmail = $this->to;
        error_log('job is failing ' . $toEmail);
    }
}
