<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DynamicTemplateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $file;
    public $sender;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $file, $sender)
    {
        $this->subject = $subject;
        $this->file = $file;
        $this->sender = $sender;
    }

    public function build()
    {
        $address = env('MAIL_FROM_ADDRESS');
        return $this->subject($this->subject)->view('admin.mail.uploaded.'.$this->file)->from($address, $this->sender);
    }
}
