<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\Jobs\Job;

// Create a queue job that will send the email.
class SendEmailJob extends Job
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        // Send the email.
        Mail::to($this->message->recipient)->send(new EmailSupportChat($this->message));
    }
}
