<?php

namespace App\Jobs;

use App\Models\ContactMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

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
        //Todo: Process the message, e.g., send an email notification
        dump('Received message', $this->contactMessage);
    }
}
