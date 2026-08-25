@props([
    'blogpost',
    'priority' => false,
])

@php
    [$imageWidth, $imageHeight] = @getimagesize(public_path($blogpost->header_image)) ?: [1600, 900];
@endphp

<a
    class="group shadow-card hover:border-accent-600/60 overflow-hidden rounded-xl border border-stone-800 bg-stone-800/30 p-1 transition-all duration-200 hover:-translate-y-1"
    href="{{ route('blogpost.show', $blogpost->slug) }}"
    data-pan="blogpost-{{ $blogpost->slug }}"
>
    <div class="h-60 overflow-hidden rounded-lg">
        <img
            src="{{ url($blogpost->header_image) }}"
            alt="{{ $blogpost->title }}"
            width="{{ $imageWidth }}"
            height="{{ $imageHeight }}"
            loading="{{ $priority ? 'eager' : 'lazy' }}"
            class="h-full w-full object-cover object-center transition-transform duration-300 group-hover:scale-105"
        />
    </div>
    <div class="p-3">
        <h3 class="py-2 text-xl font-semibold text-stone-100">{{ $blogpost->title }}</h3>
        <p class="flex items-center gap-1 pt-2 text-stone-400">
            <x-bi-clock-fill class="h-3 w-3" />
            <span class="font-mono text-sm tabular-nums">{{ $blogpost->min_read }} min read</span>
        </p>
        <p class="font-mono text-sm font-medium text-stone-400 tabular-nums">
            {{ \Carbon\Carbon::parse($blogpost->publish_date)->diffForHumans() }}
        </p>
        <p class="pt-2 pb-4 text-stone-300">
            {{ $blogpost->intro }}
        </p>
    </div>
</a>
