<x-layouts.app>
    <main
        id="main-content"
        class="flex min-h-[calc(100dvh-4rem)] flex-col items-center justify-center px-4 text-center"
    >
        <p class="font-mono text-sm tabular-nums text-accent-400">429</p>
        <h1 class="mt-2 text-balance text-4xl font-bold tracking-tight text-stone-100 md:text-5xl">Slow down.</h1>
        <p class="mt-4 max-w-[45ch] text-pretty text-stone-400">
            Too many requests in a short time. Wait a moment and try again.
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <x-atoms.button data-pan="429-home" href="/" wire:navigate>Back to home</x-atoms.button>
        </div>
    </main>
</x-layouts.app>
