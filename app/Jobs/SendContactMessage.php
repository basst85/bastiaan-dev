<?php

namespace App\Jobs;

use App\Models\ContactMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Resend\Laravel\Facades\Resend;

class SendContactMessage implements ShouldQueue
{
    use Queueable;

    public $contactMessage;

    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    public function handle(): void
    {
        Resend::emails()->send([
            'from' => 'bastiaan.dev <hello@bastiaan.dev>',
            'to' => ['hello@bastiaan.dev'],
            'subject' => 'New contact message',
            'html' => view('emails.contact-message', ['contactMessage' => $this->contactMessage])->render(),
        ]);
    }
}
