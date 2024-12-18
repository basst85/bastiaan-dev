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

<main class="flex h-screen flex-col items-center justify-center">
    <x-card class="w-1/2">
        <h1 class="text-2xl font-bold">Contact</h1>
        <p class="mb-4">Any questions or remarks? Feel free to contact me!</p>

        <x-form wire:submit="send">
            <x-input label="Naam" wire:model="name" required />
            <x-input label="E-mailadres" wire:model="email" required />
            <x-input label="Onderwerp" wire:model="subject" required />
            <x-textarea label="Bericht" wire:model="message" required class="h-64" />

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
                <x-button label="Versturen" class="btn-primary" type="submit" spinner="send" />
            </x-slot>
        </x-form>
    </x-card>
</main>
