@props(['modalTitle', 'modalWidth' => 300, 'modalHeight' => 350])

<div>
    <div
        x-data="{ show: @entangle($attributes->wire('model')) }"
        x-on:close.stop="show = false"
        x-on:keydown.escape.prevent.window="$event.stopPropagation(); show = false"
        x-show="show"
        class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-[150]"
        style="display: none;"
    >
        <div class="fixed inset-0 transform transition-all">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div
            x-show="show"
            class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto"
            style="width: {{ $modalWidth }}px !important; height: {{ $modalHeight }}px !important;"
            @click.outside="$event.stopPropagation()"
        >
            <!-- Header -->
            <div class="px-4 py-3 bg-white border-b">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $modalTitle }}
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" x-on:click="show = false">
                        <span class="sr-only">Kapat</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4">
                {{ $slot }}
            </div>

            <!-- Footer -->
            @if (isset($footer))
            <div class="px-4 py-3 bg-gray-50 text-right">
                {{ $footer }}
            </div>
            @endif
        </div>
    </div>
</div> 