@php
    $menuItems = [
        ['href' => '/', 'label' => 'Home', 'active' => request()->is('/')],
        ['href' => '/blog', 'label' => 'Blog', 'active' => request()->is('blog') || request()->is('blog/*')],
        ['href' => '/contact', 'label' => 'Contact', 'active' => request()->is('contact')],
    ];
@endphp

<header
    class="sticky top-0 z-30 border-b border-stone-800 bg-stone-900/80 text-stone-200 backdrop-blur-xl"
    x-data="{ isOpen: false }"
>
    <div class="mx-auto max-w-5xl px-4">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <a
                    href="/"
                    data-pan="header-logo"
                    wire:navigate
                    class="font-mono text-xl font-medium text-stone-100 transition-colors hover:text-accent-300"
                >
                    <span class="text-accent-400">~/</span>
                    bastiaan.dev
                </a>
            </div>
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    @foreach ($menuItems as $item)
                        <a
                            href="{{ $item['href'] }}"
                            data-pan="header-menu-{{ Str::slug($item['label']) }}"
                            wire:navigate
                            @if ($item['active']) aria-current="page" @endif
                            class="{{ $item['active'] ? 'text-accent-300' : 'text-stone-300 hover:bg-stone-800 hover:text-stone-100' }} rounded-md px-3 py-2 text-sm font-medium transition-colors"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="md:hidden" @click="isOpen = !isOpen">
                <x-atoms.hamburger isOpen="isOpen" />
            </div>
        </div>
    </div>

    <div class="md:hidden" x-show="isOpen" style="display: none">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            @foreach ($menuItems as $item)
                <a
                    href="{{ $item['href'] }}"
                    data-pan="header-menu-{{ Str::slug($item['label']) }}"
                    wire:navigate
                    @if ($item['active']) aria-current="page" @endif
                    class="{{ $item['active'] ? 'text-accent-300' : 'text-stone-300 hover:bg-stone-800 hover:text-stone-100' }} my-4 block rounded-md px-3 py-4 text-base font-medium transition-colors"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</header>
