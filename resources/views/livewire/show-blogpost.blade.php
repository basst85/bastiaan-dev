<main id="main-content" class="flex min-h-[calc(100dvh-4rem)] flex-col justify-start">
    <x-og-image>
        <div class="flex h-full w-full items-center justify-center bg-stone-900 p-16">
            <div class="flex flex-col gap-6">
                <h1 class="text-6xl font-bold text-white">{{ $blogpost->title }}</h1>
                <p class="text-2xl text-stone-400">
                    {{ $blogpost->author }} &mdash;
                    {{ \Carbon\Carbon::parse($blogpost->publish_date)->format('F j, Y') }}
                </p>
            </div>
        </div>
    </x-og-image>
    <div class="mx-auto w-full max-w-5xl px-4 py-8 md:py-12">
        <div class="motion-preset-slide-up-lg mx-auto max-w-5xl">
            <a
                href="{{ route('blog') }}"
                data-pan="blogpost-back"
                wire:navigate
                class="hover:text-accent-300 mb-6 inline-flex items-center gap-1 text-sm font-medium text-stone-400 transition-colors"
            >
                <x-bi-arrow-left class="h-4 w-4" />
                Back to blog
            </a>
            @php
                [$imageWidth, $imageHeight] = @getimagesize(public_path($blogpost->header_image)) ?: [1600, 900];
            @endphp

            <div class="h-48 w-full overflow-hidden rounded-xl md:h-96">
                <img
                    src="{{ url($blogpost->header_image) }}"
                    alt="{{ $blogpost->title }}"
                    title="{{ $blogpost->title }}"
                    width="{{ $imageWidth }}"
                    height="{{ $imageHeight }}"
                    fetchpriority="high"
                    class="h-full w-full object-cover object-center"
                />
            </div>
            <h1 class="mt-6 text-4xl font-bold tracking-tight text-balance text-stone-100">
                {{ $blogpost->title }}
            </h1>
            <p class="mt-4 flex items-center gap-1 font-mono text-sm text-stone-400">
                <x-bi-pencil class="h-4 w-4" />
                Written on {{ \Carbon\Carbon::parse($blogpost->publish_date)->format('F j, Y @ H:i') }} by
                {{ $blogpost->author }}
            </p>
            <p class="mt-1 flex items-center gap-1 font-mono text-sm text-stone-500">
                <x-bi-arrow-repeat class="h-4 w-4" />
                Last updated on {{ \Carbon\Carbon::parse($blogpost->updated_date)->format('F j, Y @ H:i') }}
            </p>

            @if (! empty($blogpost->tags))
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($blogpost->tags as $tag)
                        <a
                            href="{{ route('blogpost.tag', Str::slug($tag)) }}"
                            data-pan="blogpost-tag-{{ Str::slug($tag) }}"
                            wire:navigate
                            class="hover:border-accent-500 hover:text-accent-300 rounded-md border border-stone-700 px-2.5 py-1 font-mono text-xs text-stone-400 transition-colors"
                        >
                            {{ $tag }}
                        </a>
                    @endforeach
                </div>
            @endif

            <p class="mt-6 mb-8 w-full border-b border-stone-800"></p>

            <div class="blogpost-content overflow-x-hidden break-words">
                {!! $blogpost->contents !!}
            </div>

            @if (! empty($blogpost->faq))
                <div class="mt-10 border-t border-stone-800 pt-8">
                    <p class="text-sm font-semibold tracking-wide text-stone-500 uppercase">
                        Frequently asked questions
                    </p>
                    <div class="mt-6 divide-y divide-stone-800">
                        @foreach ($blogpost->faq as $item)
                            <details class="group py-4">
                                <summary
                                    class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-stone-100 marker:hidden [&::-webkit-details-marker]:hidden"
                                >
                                    {{ $item['question'] }}
                                    <x-bi-chevron-down
                                        class="group-open:text-accent-400 h-4 w-4 shrink-0 text-stone-500 transition-transform duration-200 group-open:rotate-180"
                                    />
                                </summary>
                                <p class="mt-3 text-stone-300">{{ $item['answer'] }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-10 border-t border-stone-800 pt-6">
                <livewire:BlogpostReact :slug="$blogpost->slug" :key="$blogpost->slug" />
            </div>
        </div>
    </div>
</main>
