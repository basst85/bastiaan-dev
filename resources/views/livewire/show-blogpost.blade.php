<main class="flex min-h-[calc(100vh-4rem)] flex-col justify-start">
    <div class="mx-auto w-full max-w-5xl px-4 py-4">
        <div class="motion-preset-slide-up-lg mx-auto max-w-5xl">
            <div class="h-48 w-full overflow-hidden rounded-lg md:h-96">
                <img
                    src="{{ url($blogpost->header_image) }}"
                    alt="{{ $blogpost->title }}"
                    title="{{ $blogpost->title }}"
                    class="w-full object-cover object-center transition-transform duration-200 hover:scale-105"
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

            <p class="mb-8 mt-4 w-full border-b-[1px] border-gray-400"></p>

            <div class="break-words overflow-x-hidden blogpost-content">
                {!! $blogpost->contents !!}
            </div>

            <div class="mt-8">
                <livewire:BlogpostReact :slug="$blogpost->slug" :key="$blogpost->slug" />
            </div>
        </div>
    </div>
</main>
