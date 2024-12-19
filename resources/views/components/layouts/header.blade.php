@php
    $menuItems = [
        ['href' => '/', 'label' => 'Home'],
        ['href' => '/blog', 'label' => 'Blog'],
        ['href' => '/contact', 'label' => 'Contact'],
    ];
@endphp

<header
    class="sticky top-0 z-30 bg-gray-800 bg-gray-900/70 text-white backdrop-blur-xl shadow-lg"
    x-data="{ isOpen: false }"
>
    <div class="px-4 mx-auto max-w-5xl">
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
                            wire:navigate
                            class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-700 hover:text-teal-200"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="md:hidden">
                <button
                    @click="isOpen = !isOpen"
                    class="inline-flex items-center justify-center rounded-md p-2 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                    :aria-expanded="isOpen"
                >
                    <span class="sr-only">Open main menu</span>
                    <svg
                        class="h-6 w-6"
                        x-show="!isOpen"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                    <svg
                        class="h-6 w-6"
                        x-show="isOpen"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        style="display: none"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="md:hidden" x-show="isOpen" style="display: none">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            @foreach ($menuItems as $item)
                <a
                    href="{{ $item['href'] }}"
                    wire:navigate
                    class="block rounded-md px-3 py-2 text-base font-medium hover:bg-gray-700"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</header>
