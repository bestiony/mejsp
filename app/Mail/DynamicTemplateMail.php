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
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $file)
    {
        $this->subject = $subject;
        $this->file = $file;
    }

    public function build()
    {
        return $this->subject($this->subject)->view('admin.mail.uploaded.'.$this->file);
    }
}
