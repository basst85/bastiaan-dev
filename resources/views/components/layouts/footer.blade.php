@php
    $menuItems = [
        ["href" => "/", "label" => "Home", "external" => false],
        ["href" => "/blog", "label" => "Blog", "external" => false],
        ["href" => "/contact", "label" => "Contact", "external" => false],
        ["href" => "https://github.com/basst85/bastiaan-dev", "label" => "Source code", "external" => true],
    ];
@endphp

<footer class="mt-16">
    <div class="mx-2 max-w-5xl border-t border-stone-800 px-4 pb-8 pt-10 md:mx-auto">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-stone-500">Quick links</p>
                <ul class="mt-4 space-y-2">
                    @foreach ($menuItems as $item)
                        <li>
                            <a
                                href="{{ $item["href"] }}"
                                data-pan="footer-menu-{{ Str::slug($item["label"]) }}"
                                class="text-stone-300 transition-colors hover:text-accent-300 hover:underline"
                                @if ($item["external"])
                                    target="_blank"
                                    rel="noopener noreferrer"
                                @endif
                            >
                                {{ $item["label"] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-stone-500">Socials</p>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a
                            href="https://github.com/basst85"
                            data-pan="footer-menu-github"
                            class="text-stone-300 transition-colors hover:text-accent-300 hover:underline"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            GitHub
                        </a>
                    </li>
                    <li>
                        <a
                            href="https://www.linkedin.com/in/bastiaan-steinmeier-6391a328/"
                            data-pan="footer-menu-linkedin"
                            class="text-stone-300 transition-colors hover:text-accent-300 hover:underline"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            LinkedIn
                        </a>
                    </li>
                    <li>
                        <a
                            href="https://discordapp.com/users/837649040316825622"
                            data-pan="footer-menu-discord"
                            class="text-stone-300 transition-colors hover:text-accent-300 hover:underline"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            Discord
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-12 text-center text-sm text-stone-500">
            <p class="font-mono tabular-nums">&copy; {{ date("Y") }} &mdash; Bastiaan Steinmeier</p>
            <p class="mt-1">
                Built with
                <x-bi-heart class="motion-preset-pulse inline h-5 w-5 fill-current text-error motion-duration-1500" />
                using Laravel and Tailwind
            </p>
        </div>
    </div>
</footer>
