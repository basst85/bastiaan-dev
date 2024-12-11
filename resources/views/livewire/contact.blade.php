<?php
    use function Livewire\Volt\{state};

    //Todo: Add validation

    $name = state('name', null);
    $subject = state('subject', null);
    $message = state('message', null);

    $send = function (): void {
        //Todo: Send email and show success message (toast)
    };
?>

<main class="flex h-screen flex-col items-center justify-center">
    <x-form wire:submit="send">
        <x-input label="Naam" wire:model="name" />
        <x-input label="Onderwerp" wire:model="subject" />
        <x-textarea label="Bericht" wire:model="message" />
        <x-slot:actions>
            <x-button label="Versturen" class="btn-primary" type="submit" spinner="send" />
        </x-slot:actions>
    </x-form>
</main>
