<?php

namespace App\Http\Services;

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
class ContactService
{
    /**
     * Send message via email
     *
     * @param array $contactData
     * @return void
     */
    public function sendMessage(array $contactData)
    {
        Mail::to('devfastfitness@gmail.com')->queue(new ContactMail($contactData));
    }
}

