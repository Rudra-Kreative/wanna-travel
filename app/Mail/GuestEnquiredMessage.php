<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GuestEnquiredMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $payload = [];
    public function __construct($payload = [])
    {
        $this->payload = $payload;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->payload['fromEmail'] ?? '')->subject('New Enquiry: '.($this->payload['subject'] ?? ''))->view('mail.guest-enquiry-template',['payload'=>$this->payload]);
    }
}
