<main class="flex min-h-[calc(100vh-4rem)] flex-col justify-start">
    <div class="mx-auto max-w-5xl px-4 py-4">
        <h1 class="text-6xl font-bold text-gray-200">
            Contact
        </h1>
        <div
            class="motion-preset-slide-up-lg mt-4 mx-auto min-w-full rounded-lg border border-gray-200 p-4 px-4 shadow-lg md:max-w-5xl"
        >
            <p class="mb-4">Any questions or remarks? Feel free to contact me!</p>

            <x-form wire:submit="send" class="md:min-w-[60rem]">
                <x-input label="Name" wire:model="name" required aria-label="Name" class="border-gray-200" />
                <x-input
                    label="Email address"
                    wire:model="email"
                    required
                    aria-label="Email address"
                    type="email"
                    class="border-gray-200"
                />
                <x-input label="Subject" wire:model="subject" required aria-label="Subject" class="border-gray-200" />
                <x-textarea
                    label="Message"
                    wire:model="message"
                    required
                    class="h-64"
                    aria-label="Message"
                    class="min-h-64 border-gray-200"
                />

                @error('error')
                    <div class="alert alert-error motion-preset-pop" role="alert">
                        <strong class="font-bold">Oeps!</strong>
                        <span class="block sm:inline">{{ $message }}</span>
                    </div>
                @enderror

                @if (session()->has('success'))
                    <div class="alert alert-success motion-preset-pop" role="alert">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <x-slot:actions>
                    <x-atoms.button submit="true" aria-label="Send contact message">Send message</x-atoms.button>
                </x-slot>
            </x-form>
        </div>
    </div>
</main>
