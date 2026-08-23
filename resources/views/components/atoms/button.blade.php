@props([
    'type' => 'primary',
    'href' => null,
    'submit' => false,
    'label' => null,
])

@php
    $classes = [
        'primary' => 'rounded-md bg-accent-500 px-4 py-2 text-center text-sm font-medium text-accent-950 transition-all duration-200 hover:bg-accent-400 active:scale-[0.98]',
        'secondary' => 'rounded-md border border-stone-700 px-4 py-2 text-center text-sm font-medium text-stone-200 transition-all duration-200 hover:border-accent-400 hover:text-accent-300 active:scale-[0.98]',
    ];
@endphp

@if ($href)
    <a href="{{ $href }}" class="{{ $classes[$type ?? 'primary'] }}">
        {{ $slot }}
    </a>
@else
    <button class="{{ $classes[$type ?? 'primary'] }}" @if ($submit) type="submit" @endif>
        {{ $slot }}
    </button>
@endif
