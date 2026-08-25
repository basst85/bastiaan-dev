<main id="main-content" class="flex min-h-[calc(100dvh-4rem)] flex-col justify-start">
    <x-og-image>
        <div class="flex h-full w-full flex-col items-center justify-center gap-6 bg-stone-900 p-16">
            <p class="text-accent-400 font-mono text-2xl">~/bastiaan.dev</p>
            <h1 class="text-6xl font-bold text-white">Blog</h1>
            <p class="text-2xl text-stone-400">Web development &amp; applied AI engineering</p>
        </div>
    </x-og-image>
    <div class="mx-auto max-w-5xl min-w-full px-4 py-8 md:min-w-[64rem] md:py-12">
        <div class="flex flex-col items-start">
            <h1 class="mb-2 text-6xl font-bold tracking-tight text-balance text-stone-100">Blog</h1>
            <div class="motion-preset-slide-up-lg mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                @foreach ($blogposts as $blogpost)
                    <x-blog-post-card :blogpost="$blogpost" :priority="$loop->index < 2" />
                @endforeach
            </div>
        </div>
    </div>
</main>
