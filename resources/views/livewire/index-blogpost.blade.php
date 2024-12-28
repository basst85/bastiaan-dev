
<main class="flex min-h-[calc(100vh-4rem)] flex-col justify-start">
    <div class="mx-auto max-w-5xl px-4 py-4 md:min-w-[64rem] min-w-full">
        <div class="flex flex-col items-start">
            <h1 class="text-6xl font-bold text-gray-200 mb-2">
                Blog
            </h1>
            <div class="motion-preset-slide-up-lg grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            @foreach ( $blogposts as $blogpost )
                <a class="border border-gray-400 rounded-lg p-1 hover:scale-105 transition-transform duration-200" href="{{route('blogpost.show', $blogpost->slug)}}">
                    <div class="rounded-lg overflow-hidden h-60">
                        <img src="{{url($blogpost->header_image)}}" alt="{{$blogpost->title}}" class="object-cover object-center">
                    </div>
                    <div class="p-2">
                        <h3 class="text-xl text-gray-200 font-bold py-2">{{$blogpost->title}}</h3>
                        <p class="flex items-center text-gray-300 pt-2">
                            <x-bi-clock-fill class="w-3 h-3 inline-block text-gray-200 mr-1" />
                            <span class="text-gray-300 font-thin">{{$blogpost->min_read}} min read</span>
                        </p>
                        <p class="text-gray-300 font-bold">
                            {{\Carbon\Carbon::parse($blogpost->publish_date)->diffForHumans()}}
                        </p>
                        <p class="text-gray-300 pt-2 pb-4">
                            {{$blogpost->intro}}
                        </p>
                    </div>
                </a>
            @endforeach
            </div>
        </div>
    </div>
</main>
