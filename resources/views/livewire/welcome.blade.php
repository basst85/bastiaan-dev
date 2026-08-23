<main id="main-content" class="relative flex min-h-[calc(100dvh-4rem)] flex-col justify-center overflow-hidden">
    <x-og-image>
        <div class="flex h-full w-full flex-col items-center justify-center gap-6 bg-stone-900 p-16">
            <p class="font-mono text-2xl text-accent-400">~/bastiaan.dev</p>
            <h1 class="text-6xl font-bold text-white">Bastiaan Steinmeier</h1>
            <p class="text-2xl text-stone-400">Full stack developer</p>
        </div>
    </x-og-image>
    <div
        class="pointer-events-none absolute -left-32 top-1/3 h-96 w-96 rounded-full bg-accent-600/10 blur-3xl"
        aria-hidden="true"
    ></div>
    <div class="mx-auto max-w-5xl px-4">
        <div class="motion-preset-slide-up-lg mx-auto max-w-5xl px-4">
            <h1 class="mb-4 text-balance text-5xl font-bold tracking-tight text-stone-100 md:text-6xl">
                Hi, I'm
                <span class="text-accent-400">Bastiaan</span>
                <br />
                Full stack developer
            </h1>

            <p class="mb-8 max-w-[52ch] text-pretty text-lg text-stone-300 md:text-xl">
                Self-taught full stack developer with a passion for building intuitive user interfaces and reliable
                backend systems.
            </p>

            <div class="mb-12 flex flex-wrap gap-4">
                <x-atoms.button data-pan="home-blog" href="/blog" wire:navigate>Read my blog</x-atoms.button>
                <x-atoms.button data-pan="home-contact" type="secondary" href="/contact" wire:navigate>
                    Contact me
                </x-atoms.button>
            </div>

            <div class="flex gap-6">
                <a
                    href="https://www.linkedin.com/in/bastiaan-steinmeier-6391a328"
                    data-pan="home-social-linkedin"
                    class="group flex items-center gap-2 text-stone-400 transition-colors hover:text-accent-300"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <x-bi-linkedin class="h-5 w-5 fill-current" />
                    <span>LinkedIn</span>
                </a>
                <a
                    href="https://github.com/basst85"
                    data-pan="home-social-github"
                    class="group flex items-center gap-2 text-stone-400 transition-colors hover:text-accent-300"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <x-bi-github class="h-5 w-5 fill-current" />
                    <span>GitHub</span>
                </a>
                <a
                    href="https://discordapp.com/users/837649040316825622"
                    data-pan="home-social-discord"
                    class="group flex items-center gap-2 text-stone-400 transition-colors hover:text-accent-300"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <x-bi-discord class="h-5 w-5 fill-current" />
                    <span>Discord</span>
                </a>
            </div>
        </div>
    </div>
</main>
