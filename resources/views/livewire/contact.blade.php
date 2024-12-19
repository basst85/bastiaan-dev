<?php
use App\Models\ContactMessage;
use App\Jobs\SendContactMessage;
use function Livewire\Volt\{state};

$name = state('name', null);
$email = state('email', null);
$subject = state('subject', null);
$message = state('message', null);

$send = function (): void {
    //Todo: Use Livewire's forms for validation
    if (empty($this->name) || empty($this->email) || empty($this->subject) || empty($this->message)) {
        $this->addError('error', 'Vul alle velden in');
        return;
    }

    if (! filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        $this->addError('error', 'Vul een geldig e-mailadres in');
        return;
    }

    $message = new ContactMessage(
        name: $this->name,
        email: $this->email,
        subject: $this->subject,
        message: $this->message,
    );

    SendContactMessage::dispatch($message);

    $this->resetErrorBag();
    $this->reset('name', 'email', 'subject', 'message');

    session()->flash('message', 'Bedankt voor je bericht.');
};
?>

<main class="flex flex-col justify-center min-h-[calc(100vh-4rem)] px-2 md:px-0">
    <div class="mx-auto min-w-full md:min-w-[50vw] p-4 rounded-lg shadow-lg border border-gray-200">
        <h1 class="text-2xl font-bold text-gray-200">Contact</h1>
        <p class="mb-4">Any questions or remarks? Feel free to contact me!</p>

        <x-form wire:submit="send">
            <x-input label="Name" wire:model="name" required aria-label="Name" />
            <x-input label="Email address" wire:model="email" required aria-label="Email address" />
            <x-input label="Subject" wire:model="subject" required aria-label="Subject" />
            <x-textarea label="Message" wire:model="message" required class="h-64" aria-label="Message" />

            @error('error')
                <div class="alert alert-error" role="alert">
                    <strong class="font-bold">Oeps!</strong>
                    <span class="block sm:inline">{{ $message }}</span>
                </div>
            @enderror

            @if (session()->has('message'))
                <div class="alert alert-success" role="alert">
                    <span>{{ session('message') }}</span>
                </div>
            @endif

            <x-slot:actions>
                <x-atoms.button submit="true" aria-label="Send contact message">
                    Send message
                </x-atoms.button>
            </x-slot>
        </x-form>
    </div>
</main>
