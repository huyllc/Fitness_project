<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class ContactMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $contactData;

    /**
     * Create a new message instance.
     *
     * @param array $contactData
     */
    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contact Mail')
                    ->from($this->contactData['email'])
                    ->view('emails.contact')
                    ->with(['contactData' => $this->contactData]);
    }
}
