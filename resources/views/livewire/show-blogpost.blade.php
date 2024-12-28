
<main class="flex min-h-[calc(100vh-4rem)] flex-col justify-start">
    <div class="mx-auto max-w-5xl px-4 py-4 md:min-w-[64rem] min-w-full">
        <div class="motion-preset-slide-up-lg mx-auto max-w-5xl">
            <div class="rounded-lg overflow-hidden md:h-96 h-48">
                <img src="{{url($blogpost->header_image)}}" alt="{{$blogpost->title}}" class="object-cover object-center hover:scale-105 transition-transform duration-200">
            </div>
            <h1 class="text-4xl font-bold text-gray-200 mt-4">
                {{ $blogpost->title }}
            </h1>
            <p class="flex items-center text-gray-300 mt-4 font-bold text-sm">
                <x-bi-pencil class="w-4 h-4 inline-block text-gray-200 mr-1" />
                Written on {{\Carbon\Carbon::parse($blogpost->publish_date)->format('F j, Y')}} by {{$blogpost->author}}
            </p>
            <p class="flex items-center text-gray-300 font-bold text-sm">
                <x-bi-arrow-repeat class="w-4 h-4 inline-block text-gray-200 mr-1" />
                Last updated on {{\Carbon\Carbon::parse($blogpost->updated_date)->format('F j, Y')}}
            </p>

            <p class="border-b-[1px] border-gray-400 w-full mt-4"></p>

            <p class="mt-8 text-gray-200">
                {{ $blogpost->contents }}
            </p>
        </div>
    </div>
</main>
