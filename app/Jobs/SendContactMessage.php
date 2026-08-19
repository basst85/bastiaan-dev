<?php

namespace App\Jobs;

use App\Models\ContactMessage;
use App\Notifications\ContactFormSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

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
        Notification::route('mail', config('mail.to_address'))
            ->notify(new ContactFormSubmitted($this->contactMessage));
    }
}
