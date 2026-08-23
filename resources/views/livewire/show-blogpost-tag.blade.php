<main id="main-content" class="flex min-h-[calc(100dvh-4rem)] flex-col justify-start">
    <x-og-image>
        <div class="flex h-full w-full flex-col items-center justify-center gap-6 bg-stone-900 p-16">
            <p class="font-mono text-2xl text-accent-400">~/bastiaan.dev</p>
            <h1 class="text-6xl font-bold text-white">{{ $tag }}</h1>
            <p class="text-2xl text-stone-400">{{ $posts->count() }} {{ Str::plural('post', $posts->count()) }}</p>
        </div>
    </x-og-image>
    <div class="mx-auto min-w-full max-w-5xl px-4 py-8 md:min-w-[64rem] md:py-12">
        <div class="flex flex-col items-start">
            <a
                href="{{ route('blog') }}"
                data-pan="tag-back-to-blog"
                wire:navigate
                class="mb-6 inline-flex items-center gap-1 text-sm font-medium text-stone-400 transition-colors hover:text-accent-300"
            >
                <x-bi-arrow-left class="h-4 w-4" />
                Back to blog
            </a>
            <p class="font-mono text-sm text-accent-400">Tag</p>
            <h1 class="mb-2 text-balance text-5xl font-bold tracking-tight text-stone-100 md:text-6xl">
                {{ $tag }}
            </h1>
            <div class="motion-preset-slide-up-lg mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                @foreach ($posts as $blogpost)
                    <x-blog-post-card :blogpost="$blogpost" :priority="$loop->index < 2" />
                @endforeach
            </div>
        </div>
    </div>
</main>
