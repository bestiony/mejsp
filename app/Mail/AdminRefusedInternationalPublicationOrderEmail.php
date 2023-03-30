<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminRefusedInternationalPublicationOrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $info;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = config("mail.from.address");
        $name = $this->info['journal'];
        $subject=$this->info['subject'];
        $from_email=$this->info['from_email'];
        return $this->subject($subject)->view('admin.mail.AdminRefusedInternationalPublicationOrderEmail')->from($address, $name);
    }
}
