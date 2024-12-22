<main class="flex min-h-[calc(100vh-4rem)] flex-col justify-center px-2 md:px-0">
    <div class="mx-auto min-w-full rounded-lg border border-gray-200 p-4 shadow-lg md:min-w-[50vw]">
        <h1 class="text-2xl font-bold text-gray-200">Contact</h1>
        <p class="mb-4">Any questions or remarks? Feel free to contact me!</p>

        <x-form wire:submit="send">
            <x-input label="Name" wire:model="name" required aria-label="Name" />
            <x-input label="Email address" wire:model="email" required aria-label="Email address" type="email" />
            <x-input label="Subject" wire:model="subject" required aria-label="Subject" />
            <x-textarea label="Message" wire:model="message" required class="h-64" aria-label="Message" />

            @error('error')
                <div class="alert alert-error" role="alert">
                    <strong class="font-bold">Oeps!</strong>
                    <span class="block sm:inline">{{ $message }}</span>
                </div>
            @enderror

            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <x-slot:actions>
                <x-atoms.button submit="true" aria-label="Send contact message">Send message</x-atoms.button>
            </x-slot>
        </x-form>
    </div>
</main>
