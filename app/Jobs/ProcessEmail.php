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
    protected $app_base_name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $view, $subject, $data, $app_base_name)
    {
        $this->to = $to;
        $this->view = $view;
        $this->subject = $subject;
        $this->data = $data;
        $this->app_base_name = $app_base_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toEmail = $this->to;
        $subject = $this->subject;
        $app_base_name = $this->app_base_name;

        error_log('trying to send ' . $toEmail);
        try {
            Mail::send($this->view, $this->data, function ($message) use ($toEmail, $subject, $app_base_name) {
                $message->from('gotocva@gmail.com', 'Mail from ' . $app_base_name);
                $message->to($toEmail);
                $message->subject($subject);
            });
            error_log('email send to ' . $toEmail);
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
