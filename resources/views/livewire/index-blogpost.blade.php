@section('meta')
    <title>Blogpost overview - {{ config('app.name') }}</title>
    <meta name="description" content="A collection of blogposts by Bastiaan Steinmeier" />
    <meta name="keywords" content="blog, blogposts, javascript, php, development, ai, Bastiaan Steinmeier" />
@endsection

<main class="flex min-h-[calc(100vh-4rem)] flex-col justify-start">
    <div class="mx-auto min-w-full max-w-5xl px-4 py-4 md:min-w-[64rem]">
        <div class="flex flex-col items-start">
            <h1 class="mb-2 text-6xl font-bold text-gray-200">Blog</h1>
            <div class="motion-preset-slide-up-lg mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach ($blogposts as $blogpost)
                    <a
                        class="rounded-lg border border-gray-400 p-1 transition-transform duration-200 hover:scale-105"
                        href="{{ route('blogpost.show', $blogpost->slug) }}"
                        data-pan="blogpost-{{ $blogpost->slug }}"
                    >
                        <div class="h-60 overflow-hidden rounded-lg">
                            <img
                                src="{{ url($blogpost->header_image) }}"
                                alt="{{ $blogpost->title }}"
                                class="object-cover object-center"
                            />
                        </div>
                        <div class="p-2">
                            <h3 class="py-2 text-xl font-bold text-gray-200">{{ $blogpost->title }}</h3>
                            <p class="flex items-center pt-2 text-gray-300">
                                <x-bi-clock-fill class="mr-1 inline-block h-3 w-3 text-gray-200" />
                                <span class="font-thin text-gray-300">{{ $blogpost->min_read }} min read</span>
                            </p>
                            <p class="font-bold text-gray-300">
                                {{ \Carbon\Carbon::parse($blogpost->publish_date)->diffForHumans() }}
                            </p>
                            <p class="pb-4 pt-2 text-gray-300">
                                {{ $blogpost->intro }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</main>
