@php
    $menuItems = [
        ['href' => '/', 'label' => 'Home', 'external' => false],
        ['href' => '/blog', 'label' => 'Blog', 'external' => false],
        ['href' => '/contact', 'label' => 'Contact', 'external' => false],
        ['href' => 'https://github.com/basst85/bastiaan-dev', 'label' => 'Source code', 'external' => true]
    ];
@endphp

<footer class="mt-12">
    <div class="mx-2 max-w-5xl px-4 pt-8 pb-4 border-t border-gray-200 md:mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-2xl font-bold">Quick links</p>
                <ul class="mt-4 space-y-2">
                    @foreach ($menuItems as $item)
                        <li>
                            <a
                                href="{{ $item['href'] }}"
                                class="hover:text-teal-200 hover:underline"
                                @if ($item['external'])
                                    target="_blank" rel="noopener noreferrer"
                                @endif
                            >
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <p class="text-2xl font-bold">Socials</p>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a
                            href="https://github.com/basst85"
                            class="hover:text-teal-200 hover:underline"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            GitHub
                        </a>
                    </li>
                    <li>
                        <a
                            href="https://www.linkedin.com/in/bastiaan-steinmeier-6391a328/"
                            class="hover:text-teal-200 hover:underline"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            LinkedIn
                        </a>
                    </li>
                    <li>
                        <a
                            href="https://discordapp.com/users/837649040316825622"
                            class="hover:text-teal-200 hover:underline"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            Discord
                        </a>
                </ul>
            </div>
        </div>
        <div class="mt-12 text-center text-gray-400 text-sm">
            <p>&copy; {{ date('Y') }} - Bastiaan Steinmeier<p>
            <p>Built with <x-bi-heart class="h-5 w-5 fill-current text-red-500 inline" /> using Laravel and Tailwind</p>
        </div>
    </div>
</footer>
