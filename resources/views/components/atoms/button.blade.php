@props([
    'type' => 'primary',
    'href' => null,
    'submit' => false,
    'label' => null,
])

@php
    $classes = [
        'primary' => 'rounded-md bg-gray-700 px-4 py-2 text-center text-sm font-medium text-gray-100 transition-colors hover:bg-gray-600 hover:text-teal-200',
        'secondary' => 'rounded-md px-4 py-2 text-center text-sm font-medium text-gray-100 transition-colors hover:bg-gray-600 hover:text-teal-200',
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
