<div class="flex items-center space-x-4">
    <button
        wire:click="addReaction('like')"
        aria-label="React with like"
        class="group flex transform items-center space-x-1 text-stone-300 transition duration-300 ease-in-out hover:scale-110 hover:text-sky-400 active:scale-95"
    >
        <x-bi-hand-thumbs-up-fill class="h-6 w-6" />
        @if ($reactionCounts['like'] > 0)
            <span class="font-mono text-sm font-medium tabular-nums group-hover:text-sky-400">
                {{ $reactionCounts['like'] }}
            </span>
        @endif
    </button>
    <button
        wire:click="addReaction('love')"
        aria-label="React with love"
        class="group flex transform items-center space-x-1 text-stone-300 transition duration-300 ease-in-out hover:scale-110 hover:text-rose-400 active:scale-95"
    >
        <x-bi-heart-fill class="h-6 w-6" />
        @if ($reactionCounts['love'] > 0)
            <span class="font-mono text-sm font-medium tabular-nums group-hover:text-rose-400">
                {{ $reactionCounts['love'] }}
            </span>
        @endif
    </button>
    <button
        wire:click="addReaction('wow')"
        aria-label="React with wow"
        class="group flex transform items-center space-x-1 text-stone-300 transition duration-300 ease-in-out hover:scale-110 hover:text-amber-400 active:scale-95"
    >
        <x-bi-emoji-surprise-fill class="h-6 w-6" />
        @if ($reactionCounts['wow'] > 0)
            <span class="font-mono text-sm font-medium tabular-nums group-hover:text-amber-400">
                {{ $reactionCounts['wow'] }}
            </span>
        @endif
    </button>
    <button
        wire:click="addReaction('haha')"
        aria-label="React with haha"
        class="group flex transform items-center space-x-1 text-stone-300 transition duration-300 ease-in-out hover:scale-110 hover:text-amber-400 active:scale-95"
    >
        <x-bi-emoji-laughing-fill class="h-6 w-6" />
        @if ($reactionCounts['haha'] > 0)
            <span class="font-mono text-sm font-medium tabular-nums group-hover:text-amber-400">
                {{ $reactionCounts['haha'] }}
            </span>
        @endif
    </button>
    @if (session()->has('message'))
        <p class="text-stone-300">
            {{ session('message') }}
        </p>
    @endif
</div>
