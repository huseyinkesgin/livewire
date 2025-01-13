@props([
    'modalTitle' => '',
    'mode' => 'create',
    'modalWidth' => 300,
    'modalHeight' => 350
])

<div
    x-data="{
        show: @entangle($attributes->wire('model')),
        init() {
            this.$watch('show', value => {
                if (value) {
                    this.$nextTick(() => {
                        this.$refs.code.focus();
                    });
                } else {
                    this.$dispatch('closeModal');
                }
            });
        }
    }"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity"
        >
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle"
            :style="{ width: '{{ $modalWidth }}px', height: '{{ $modalHeight }}px' }"
        >
            <!-- Modal Header -->
            <div class="px-4 py-3 bg-gray-50 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $modalTitle }}
                    </h3>
                    <div class="inline-flex gap-0.5">
                        <button type="button" wire:click="save" class="focus:outline-none">
                            <x-icons name="save" />
                        </button>
                        <button type="button" wire:click="$set('showModal', false)" class="focus:outline-none">
                            <x-icons name="close" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="px-4 py-3">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
