@props([
    'isOpen' => false,
])

<button class="group h-10 w-10">
    <div class="grid justify-items-end gap-1.5">
        <span
            class="h-0.5 w-7 rounded-full bg-white transition duration-300 group-hover:bg-teal-200"
            x-bind:class="{ '-rotate-45': isOpen, 'translate-y-2': isOpen }"
        ></span>
        <span
            class="h-0.5 w-7 rounded-full bg-white transition duration-150 group-hover:bg-teal-200"
            x-bind:class="{ 'scale-x-0 ': isOpen }"
        ></span>
        <span
            class="h-0.5 w-4 rounded-full bg-white transition duration-300 group-hover:bg-teal-200"
            x-bind:class="{
                'rotate-45': isOpen,
                '-translate-y-2': isOpen,
                'w-7': isOpen,
            }"
        ></span>
    </div>
</button>
