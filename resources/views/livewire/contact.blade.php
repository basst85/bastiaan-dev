<main id="main-content" class="flex min-h-[calc(100dvh-4rem)] flex-col justify-start">
    <x-og-image>
        <div class="flex h-full w-full flex-col items-center justify-center gap-6 bg-stone-900 p-16">
            <p class="text-accent-400 font-mono text-2xl">~/bastiaan.dev</p>
            <h1 class="text-6xl font-bold text-white">Contact</h1>
            <p class="text-2xl text-stone-400">Let's talk about your project</p>
        </div>
    </x-og-image>
    <div class="mx-auto max-w-5xl px-4 py-8 md:py-12">
        <h1 class="text-6xl font-bold tracking-tight text-balance text-stone-100">Contact</h1>
        <div
            class="motion-preset-slide-up-lg shadow-card mx-auto mt-6 min-w-full rounded-xl border border-stone-800 bg-stone-800/20 p-4 px-4 md:max-w-5xl md:p-6"
        >
            <p class="mb-4 text-stone-300">Any questions or remarks? Feel free to reach out.</p>

            <x-form wire:submit="send" class="space-y-4 md:min-w-[60rem]">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-stone-200">
                            Name
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <input
                        type="text"
                        wire:model="name"
                        required
                        aria-label="Name"
                        class="input input-lg input-bordered w-full"
                    />
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-stone-200">
                            Email address
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <label class="input input-lg input-bordered flex items-center gap-2">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-5 w-5 opacity-70"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"
                            />
                        </svg>
                        <input type="email" wire:model="email" required aria-label="Email address" class="grow" />
                    </label>
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-stone-200">
                            Subject
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <input
                        type="text"
                        wire:model="subject"
                        required
                        aria-label="Subject"
                        class="input input-lg input-bordered w-full"
                    />
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-stone-200">
                            Message
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <textarea
                        wire:model="message"
                        required
                        aria-label="Message"
                        rows="8"
                        class="textarea textarea-bordered textarea-lg min-h-48 w-full"
                    ></textarea>
                </div>

                @error('error')
                    <div class="alert alert-error motion-preset-pop" role="alert">
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
