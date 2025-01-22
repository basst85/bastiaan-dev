@section('meta')
    <title>{{ $blogpost->title }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ $blogpost->intro }}" />
    <meta name="keywords" content="{{ $blogpost->tags }}" />
    <meta name="last-modified" content="{{ $blogpost->updated_date }}" />
    <meta name="author" content="{{ $blogpost->author }}" />
    <meta name="robots" content="index, follow" />

    <meta property="og:title" content="{{ $blogpost->title }} - {{ config('app.name') }}" />
    <meta property="og:description" content="{{ $blogpost->intro }}" />
    <meta property="og:image" content="{{ url($blogpost->header_image) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <meta property="og:locale" content="{{ app()->getLocale() }}" />
    <meta property="article:published_time" content="{{ $blogpost->publish_date }}" />
    <meta property="article:modified_time" content="{{ $blogpost->updated_date }}" />
    <meta property="article:author" content="{{ $blogpost->author }}" />

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Article",
            "headline": "{{ $blogpost->title }}",
            "description": "{{ $blogpost->intro }}",
            "image": "{{ url($blogpost->header_image) }}",
            "author": {
                "@type": "Person",
                "name": "{{ $blogpost->author }}"
            },
            "datePublished": "{{ $blogpost->publish_date }}",
            "dateModified": "{{ $blogpost->updated_date }}"
        }
    </script>
@endsection

<main class="flex min-h-[calc(100vh-4rem)] flex-col justify-start">
    <div class="mx-auto min-w-full max-w-5xl px-4 py-4">
        <div class="motion-preset-slide-up-lg mx-auto max-w-5xl">
            <div class="h-48 w-full overflow-hidden rounded-lg md:h-96">
                <img
                    src="{{ url($blogpost->header_image) }}"
                    alt="{{ $blogpost->title }}"
                    title="{{ $blogpost->title }}"
                    class="min-w-full object-cover object-center transition-transform duration-200 hover:scale-105"
                />
            </div>
            <h1 class="mt-4 text-4xl font-bold text-gray-200">
                {{ $blogpost->title }}
            </h1>
            <p class="mt-4 flex items-center text-sm font-bold text-gray-300">
                <x-bi-pencil class="mr-1 inline-block h-4 w-4 text-gray-200" />
                Written on {{ \Carbon\Carbon::parse($blogpost->publish_date)->format('F j, Y @ H:i') }} by
                {{ $blogpost->author }}
            </p>
            <p class="flex items-center text-sm font-bold text-gray-300">
                <x-bi-arrow-repeat class="mr-1 inline-block h-4 w-4 text-gray-200" />
                Last updated on {{ \Carbon\Carbon::parse($blogpost->updated_date)->format('F j, Y @ H:i') }}
            </p>

            <p class="mt-4 mb-8 w-full border-b-[1px] border-gray-400"></p>

            <div class="blogpost-content">
                {{ $blogpost->contents }}
            </div>

            <div class="mt-8">
                <livewire:BlogpostReact :slug="$blogpost->slug" :key="$blogpost->slug" />
            </div>
        </div>
    </div>
</main>
