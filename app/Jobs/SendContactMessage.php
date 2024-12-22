<?php

namespace App\Jobs;

use App\Models\ContactMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Notification;
use App\Notifications\ContactFormSubmitted;

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
        Notification::route('mail', env('MAIL_TO_ADDRESS'))
            ->notify(new ContactFormSubmitted($this->contactMessage));
    }
}
