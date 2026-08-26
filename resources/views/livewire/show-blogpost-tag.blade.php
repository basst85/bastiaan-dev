<main id="main-content" class="flex min-h-[calc(100dvh-4rem)] flex-col justify-start">
    <x-og-image>
        <div class="flex h-full w-full flex-col items-center justify-center gap-6 bg-stone-900 p-16">
            <p class="text-accent-400 font-mono text-2xl">~/bastiaan.dev</p>
            <h1 class="text-6xl font-bold text-white">{{ $tag }}</h1>
            <p class="text-2xl text-stone-400">{{ $posts->count() }} {{ Str::plural('post', $posts->count()) }}</p>
        </div>
    </x-og-image>
    <div class="mx-auto max-w-5xl min-w-full px-4 py-8 md:min-w-[64rem] md:py-12">
        <div class="flex flex-col items-start">
            <a
                href="{{ route('blog') }}"
                data-pan="tag-back-to-blog"
                wire:navigate
                class="hover:text-accent-300 mb-6 inline-flex items-center gap-1 text-sm font-medium text-stone-400 transition-colors"
            >
                <x-bi-arrow-left class="h-4 w-4" />
                Back to blog
            </a>
            <p class="text-accent-400 font-mono text-sm">Tag</p>
            <h1 class="mb-2 text-5xl font-bold tracking-tight text-balance text-stone-100 md:text-6xl">
                {{ $tag }}
            </h1>
            <div class="blog-grid mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                @foreach ($posts as $blogpost)
                    <x-blog-post-card :blogpost="$blogpost" :priority="$loop->index < 2" />
                @endforeach
            </div>
        </div>
    </div>
</main>
