<x-layouts.app>
    <main
        id="main-content"
        class="flex min-h-[calc(100dvh-4rem)] flex-col items-center justify-center px-4 text-center"
    >
        <p class="font-mono text-sm tabular-nums text-accent-400">419</p>
        <h1 class="mt-2 text-balance text-4xl font-bold tracking-tight text-stone-100 md:text-5xl">
            This page expired.
        </h1>
        <p class="mt-4 max-w-[45ch] text-pretty text-stone-400">
            Your session timed out, probably because this page was open for a while. Go back and try submitting again.
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <button
                type="button"
                onclick="history.back()"
                data-pan="419-back"
                class="rounded-md bg-accent-500 px-4 py-2 text-center text-sm font-medium text-accent-950 transition-all duration-200 hover:bg-accent-400 active:scale-[0.98]"
            >
                Go back
            </button>
            <x-atoms.button data-pan="419-home" type="secondary" href="/" wire:navigate>Back to home</x-atoms.button>
        </div>
    </main>
</x-layouts.app>
