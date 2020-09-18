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

class ProcessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $to;
    protected $view;
    protected $data;
    protected $subject;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $view, $subject, $data)
    {
        $this->to = $to;
        $this->view = $view;
        $this->subject = $subject;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            error_log('sending email');
            Mail::send($this->view, $this->data, function ($message) {
                $message->from('gotocva@gmail.com', 'Mail from ' . $this->data['APP_BASE_NAME']);
                $message->to($this->to);
                $message->subject($this->subject);
            });
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function failed()
    {
        $toEmail = $this->to;
        error_log('job is failing ' . $toEmail);
    }
}
