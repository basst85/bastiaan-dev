@php
    $menuItems = [
        ['href' => '/', 'label' => 'Home'],
        ['href' => '/blog', 'label' => 'Blog'],
        ['href' => '/contact', 'label' => 'Contact'],
    ];
@endphp

<header
    class="sticky top-0 z-30 bg-gray-800 bg-gray-900/70 text-white shadow-lg backdrop-blur-xl"
    x-data="{ isOpen: false }"
>
    <div class="mx-auto max-w-5xl px-4">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <a
                    href="/"
                    class="bg-gradient-to-r from-teal-400 to-indigo-500 bg-clip-text text-3xl font-medium text-transparent transition-transform duration-500 hover:scale-110"
                >
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
                            class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-700 hover:text-teal-200"
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
                    class="my-4 block rounded-md px-3 py-4 text-base font-medium hover:bg-gray-700"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</header>
