<x-layouts.app>
    <main
        id="main-content"
        class="flex min-h-[calc(100dvh-4rem)] flex-col items-center justify-center px-4 text-center"
    >
        <p class="text-accent-400 font-mono text-sm tabular-nums">500</p>
        <h1 class="mt-2 text-4xl font-bold tracking-tight text-balance text-stone-100 md:text-5xl">
            Something went wrong.
        </h1>
        <p class="mt-4 max-w-[45ch] text-pretty text-stone-400">
            The server ran into a problem loading this page. It's already been logged — try again in a moment.
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <x-atoms.button data-pan="500-home" href="/" wire:navigate>Back to home</x-atoms.button>
            <button
                type="button"
                onclick="location.reload()"
                data-pan="500-retry"
                class="hover:border-accent-400 hover:text-accent-300 rounded-md border border-stone-700 px-4 py-2 text-center text-sm font-medium text-stone-200 transition-all duration-200 active:scale-[0.98]"
            >
                Try again
            </button>
        </div>
    </main>
</x-layouts.app>
