@props(['modalWidth', 'modalHeight'])

<div
    x-data="{ 
        show: @entangle($attributes->wire('model')).live,
        activeRow: null,
        activeIndex: 0,
        rows: [],
        init() {
            this.$watch('show', value => {
                if (value) {
                    this.$nextTick(() => {
                        this.rows = [...this.$el.querySelectorAll('tbody tr')];
                        if (this.rows.length > 0) {
                            this.activeIndex = 0;
                            this.activeRow = this.rows[0].getAttribute('data-id');
                            this.rows[0].focus();
                        }
                    });
                }
            });
        },
        handleKeyDown(event) {
            if (!this.show) return;

            switch(event.key) {
                case 'ArrowDown':
                    event.preventDefault();
                    if (this.activeIndex < this.rows.length - 1) {
                        this.activeIndex++;
                        this.activeRow = this.rows[this.activeIndex].getAttribute('data-id');
                        this.rows[this.activeIndex].focus();
                    }
                    break;
                case 'ArrowUp':
                    event.preventDefault();
                    if (this.activeIndex > 0) {
                        this.activeIndex--;
                        this.activeRow = this.rows[this.activeIndex].getAttribute('data-id');
                        this.rows[this.activeIndex].focus();
                    }
                    break;
                case 'Enter':
                    event.preventDefault();
                    if (this.activeRow) {
                        this.$wire.select(this.activeRow);
                    }
                    break;
                case 'Escape':
                    this.show = false;
                    break;
            }
        }
    }"
    x-on:close.stop="show = false"
    x-on:keydown.window="handleKeyDown($event)"
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-[100]"
    style="display: none;"
>
    <div class="fixed inset-0 transform transition-all">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div
        x-show="show"
        class="relative mx-auto bg-white overflow-hidden shadow-xl transform transition-all"
        style="width: {{ $modalWidth }}px !important; height: {{ $modalHeight }}px !important;"
    >
        <!-- Header -->
        <div class="px-4 py-3 bg-white border-b">
            <div class="inline-flex gap-0.5">
                <button type="button" wire:click="create" class="focus:outline-none">
                    <x-icons name="new" />
                </button>
                <button type="button" wire:click="select" class="focus:outline-none">
                    <x-icons name="select" />
                </button>
                <button type="button" wire:click="delete" class="focus:outline-none">
                    <x-icons name="delete" />
                </button>
                <button type="button" wire:click="refresh" class="focus:outline-none">
                    <x-icons name="refresh" />
                </button>
                <button type="button" x-on:click="show = false" class="focus:outline-none">
                    <x-icons name="close" />
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4 h-[calc(100%-88px)] overflow-auto">
            {{ $slot }}
        </div>
    </div>
</div> 