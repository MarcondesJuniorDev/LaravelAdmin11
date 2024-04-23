@props(['id', 'title'])

<div x-show="isOpen" x-cloak class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center">
    <div class="fixed inset-0 bg-black opacity-50"></div>

    <div id="{{ $id }}" class="bg-white rounded-lg shadow-xl overflow-hidden" role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-title" x-show.transition="isOpen">
        <div class="flex justify-between items-center p-4 bg-gray-800 text-white">
            <h3 id="{{ $id }}-title" class="text-lg font-semibold">{{ $title }}</h3>
            <button x-on:click="isOpen = false" class="text-white">&times;</button>
        </div>

        <div class="p-4">
            {{ $slot }}
        </div>
    </div>
</div>
