@props([
    'type' => 'primary',
    'href' => null,
    'submit' => false,
    'label' => null,
])

@php
    $classes = [
        'primary' => 'bg-accent-500 text-accent-950 hover:bg-accent-400 rounded-md px-4 py-2 text-center text-sm font-medium transition-all duration-200 active:scale-[0.98]',
        'secondary' => 'hover:border-accent-400 hover:text-accent-300 rounded-md border border-stone-700 px-4 py-2 text-center text-sm font-medium text-stone-200 transition-all duration-200 active:scale-[0.98]',
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
