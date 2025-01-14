@props([
    'modalTitle' => '',
    'mode' => 'create',
    'modalWidth' => 300,
    'modalHeight' => 350,
])

<div x-data="{
    show: @entangle($attributes->wire('model')),
    init() {
        this.$watch('show', value => {
            if (value) {
                this.$nextTick(() => {
                    const codeInput = this.$refs.code;
                    if (codeInput) {
                        codeInput.focus();
                    }
                });
            }
        });
    },
    handleKeyDown(event) {
        if (!this.show) return;

        if (event.key === 's' && event.ctrlKey) {
            event.preventDefault();
            @this.save();
        } else if (event.key === 'Escape') {
            event.preventDefault();
            this.show = false;
        }
    }
}" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
    @keydown.window="handleKeyDown($event)">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div x-show="show" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle"
            :style="{ width: '{{ $modalWidth }}px', height: '{{ $modalHeight }}px' }">
            <!-- Modal Header -->
            <div class="px-4 py-3 bg-gray-50 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $modalTitle }}
                    </h3>
                    <div class="inline-flex gap-0.5">
                        <button type="button" wire:click="save"
                            class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            tabindex="0">
                            <x-icons name="save" />
                        </button>
                        <button type="button" wire:click="$set('showModal', false)"
                            class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            tabindex="0">
                            <x-icons name="close" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="px-4 py-3">
                <div x-trap.inert.noscroll="show">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
