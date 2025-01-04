<div class="flex items-center space-x-4">
    <button
        wire:click="addReaction('like')"
        class="transform text-gray-200 transition duration-500 ease-in-out hover:scale-125 hover:text-blue-500"
    >
        <x-bi-hand-thumbs-up-fill class="h-6 w-6" />
    </button>
    <button
        wire:click="addReaction('love')"
        class="transform text-gray-200 transition duration-500 ease-in-out hover:scale-125 hover:text-red-500"
    >
        <x-bi-heart-fill class="h-6 w-6" />
    </button>
    <button
        wire:click="addReaction('wow')"
        class="transform text-gray-200 transition duration-500 ease-in-out hover:scale-125 hover:text-yellow-500"
    >
        <x-bi-emoji-surprise-fill class="h-6 w-6" />
    </button>
    <button
        wire:click="addReaction('haha')"
        class="transform text-gray-200 transition duration-500 ease-in-out hover:scale-125 hover:text-yellow-500"
    >
        <x-bi-emoji-laughing-fill class="h-6 w-6" />
    </button>
    @if (session()->has('message'))
        <p class="text-gray-200">
            {{ session('message') }}
        </p>
    @endif
</div>
