@php
    $menuItems = [
        ['href' => '/', 'label' => 'Home'],
        ['href' => '/blog', 'label' => 'Blog'],
        ['href' => '/contact', 'label' => 'Contact'],
    ];
@endphp

<nav class="bg-gray-800 text-white" x-data="{ isOpen: false }">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="/" class="text-xl font-bold">
                    Logo
                </a>
            </div>
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    @foreach ($menuItems as $item)
                        <a href="{{ $item['href'] }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="md:hidden">
                <button @click="isOpen = !isOpen"
                        class="inline-flex items-center justify-center p-2 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        :aria-expanded="isOpen">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" x-show="isOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="md:hidden" x-show="isOpen" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            @foreach ($menuItems as $item)
                <a href="{{ $item['href'] }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</nav>

