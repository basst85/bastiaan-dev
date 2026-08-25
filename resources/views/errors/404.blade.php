<x-layouts.app>
    <main
        id="main-content"
        class="flex min-h-[calc(100dvh-4rem)] flex-col items-center justify-center px-4 text-center"
    >
        <p class="text-accent-400 font-mono text-sm tabular-nums">404</p>
        <h1 class="mt-2 text-4xl font-bold tracking-tight text-balance text-stone-100 md:text-5xl">
            This page doesn't exist.
        </h1>
        <p class="mt-4 max-w-[45ch] text-pretty text-stone-400">
            The page you're looking for was moved, renamed, or never existed. Check the address, or head back to
            somewhere that does.
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <x-atoms.button data-pan="404-home" href="/" wire:navigate>Back to home</x-atoms.button>
            <x-atoms.button data-pan="404-blog" type="secondary" href="/blog" wire:navigate>
                Read the blog
            </x-atoms.button>
        </div>
    </main>
</x-layouts.app>
