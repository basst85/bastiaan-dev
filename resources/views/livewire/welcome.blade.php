<main class="flex min-h-[calc(100vh-4rem)] flex-col justify-center">
    <div class="mx-auto max-w-5xl px-4">
        <div class="motion-preset-slide-up-lg mx-auto max-w-5xl px-4">
            <h1 class="mb-4 text-5xl font-bold text-gray-100 md:text-6xl">
                Hi!
                <br />
                I'm
                <span class="bg-gradient-to-r from-teal-400 to-indigo-500 bg-clip-text text-transparent">Bastiaan</span>
                - Full Stack Developer
            </h1>

            <p class="mb-8 text-lg text-gray-300 md:text-xl">
                Dedicated self-taught Full Stack Developer with a passion for creating intuitive user interfaces and efficient
                backend systems.
            </p>

            <div class="mb-12 flex flex-wrap gap-4">
                <x-atoms.button href="/blog" wire:navigate>Read my blog</x-atoms.button>
                <x-atoms.button href="/contact" wire:navigate>Contact me</x-atoms.button>
            </div>

            <div class="flex gap-6">
                <a
                    href="https://www.linkedin.com/in/bastiaan-steinmeier-6391a328"
                    class="group flex items-center gap-2 text-gray-400 transition-colors"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <x-bi-linkedin class="h-5 w-5 fill-current group-hover:text-teal-200" />
                    <span>LinkedIn</span>
                </a>
                <a
                    href="https://github.com/basst85"
                    class="transition-color group flex items-center gap-2 text-gray-400"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <x-bi-github class="h-5 w-5 fill-current group-hover:text-teal-200" />
                    <span>GitHub</span>
                </a>
                <a
                    href="https://discordapp.com/users/837649040316825622"
                    class="transition-color group flex items-center gap-2 text-gray-400"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <x-bi-discord class="h-5 w-5 fill-current group-hover:text-teal-200" />
                    <span>Discord</span>
                </a>
            </div>
        </div>
    </div>
</main>
