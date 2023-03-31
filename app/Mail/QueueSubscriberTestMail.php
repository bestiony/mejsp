<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QueueSubscriberTestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = config("mail.from.address");
        $subject= "Test Email";
        // $from_email=$this->details['email_sender'];
        $name = "Name of test email";
        return $this->subject($subject)->view('admin.SubscriberTestMail')->from($address, $name);
    }
}
