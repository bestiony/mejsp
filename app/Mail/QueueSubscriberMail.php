<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QueueSubscriberMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = config("mail.from.address");
        $subject=$this->details['subject'];
        $from_email=$this->details['email_sender'];
        $name = $this->details['name_of_email'];
        return $this->subject($subject)->view('admin.SubscriberMail')->from($address, $name)->with('details', $this->details);
    }
}
