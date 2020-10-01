<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Helper;

class ProcessMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $number;
    protected $message;
    protected $property_id;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($number, $message, $property_id, $type)
    {
        $this->number = $number;
        $this->message = $message;
        $this->property_id = $property_id;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Helper::send_message($this->number, $this->message, $this->property_id, $this->type);
    }
}
