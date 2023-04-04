<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class NotificationsInternationalPublishingMail extends Mailable
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
        $address = env('INTERNATIONAL_FROM_ADDRESS');
        $subject = $this->info['subject'];
        return $this->subject($subject)->view('admin.mail.NotificationsInternationalPublishingMail')->from($address);
    }



}
