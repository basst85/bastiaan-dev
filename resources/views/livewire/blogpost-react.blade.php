<div class="flex items-center space-x-4">
    <button
        wire:click="addReaction('like')"
        class="group flex items-center space-x-1 transform text-gray-200 transition duration-500 ease-in-out hover:scale-110 hover:text-blue-500"
    >
        <x-bi-hand-thumbs-up-fill class="h-6 w-6" />
        @if($reactionCounts['like'] > 0)
            <span class="text-sm font-medium group-hover:text-blue-500">{{ $reactionCounts['like'] }}</span>
        @endif
    </button>
    <button
        wire:click="addReaction('love')"
        class="group flex items-center space-x-1 transform text-gray-200 transition duration-500 ease-in-out hover:scale-110 hover:text-red-500"
    >
        <x-bi-heart-fill class="h-6 w-6" />
        @if($reactionCounts['love'] > 0)
            <span class="text-sm font-medium group-hover:text-red-500">{{ $reactionCounts['love'] }}</span>
        @endif
    </button>
    <button
        wire:click="addReaction('wow')"
        class="group flex items-center space-x-1 transform text-gray-200 transition duration-500 ease-in-out hover:scale-110 hover:text-yellow-500"
    >
        <x-bi-emoji-surprise-fill class="h-6 w-6" />
        @if($reactionCounts['wow'] > 0)
            <span class="text-sm font-medium group-hover:text-yellow-500">{{ $reactionCounts['wow'] }}</span>
        @endif
    </button>
    <button
        wire:click="addReaction('haha')"
        class="group flex items-center space-x-1 transform text-gray-200 transition duration-500 ease-in-out hover:scale-110 hover:text-yellow-500"
    >
        <x-bi-emoji-laughing-fill class="h-6 w-6" />
        @if($reactionCounts['haha'] > 0)
            <span class="text-sm font-medium group-hover:text-yellow-500">{{ $reactionCounts['haha'] }}</span>
        @endif
    </button>
    @if (session()->has('message'))
        <p class="text-gray-200">
            {{ session('message') }}
        </p>
    @endif
</div>
