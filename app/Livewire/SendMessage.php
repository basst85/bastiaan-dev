<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContactMessage;
use App\Jobs\SendContactMessage;
use Livewire\Attributes\Validate;


class SendMessage extends Component
{

    #[Validate('required')]
    public $name;

    #[Validate('required|min:10|email')]
    public $email;

    #[Validate('required|min:5')]
    public $subject;

    #[Validate('required|min:10')]
    public $message;

    public function send()
    {
        $this->validate();

        $contactMessage = new ContactMessage(
            name: $this->name,
            email: $this->email,
            subject: $this->subject,
            message: $this->message
        );

        SendContactMessage::dispatch($contactMessage);

        session()->flash('success', 'Thanks for your message! I will get back to you as soon as possible.');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.contact');
    }
}
