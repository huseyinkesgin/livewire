@props([
    'records',
    'columns' => [],
    'sortField' => null,
    'sortDirection' => 'desc',
    'search' => '',
    'perPage' => 20,
    'activeRow' => null,
])

<div x-data="{
    activeRow: null,
    activeIndex: 0,
    rows: [],
    init() {
        this.rows = [...this.$el.querySelectorAll('tbody tr')];
        if (this.rows.length > 0) {
            this.activeRow = this.rows[0].getAttribute('data-id');
            @this.setActiveRow(this.activeRow);
        }

        // Record saved handler
        Livewire.on('recordSaved', ({ id }) => {
            this.$nextTick(() => {
                @this.setActiveRow(id);
            });
        });

        // Row activation handler
        Livewire.on('row-activated', ({ id }) => {
            this.$nextTick(() => {
                this.rows = [...this.$el.querySelectorAll('tbody tr')];
                const row = this.rows.find(row => row.getAttribute('data-id') == id);
                if (row) {
                    this.activeRow = id;
                }
            });
        });
    },
    handleKeyDown(event) {
        this.rows = [...this.$el.querySelectorAll('tbody tr')];
        const currentIndex = this.rows.findIndex(row => row.getAttribute('data-id') == this.activeRow);

        switch (event.key) {
            case 'ArrowDown':
                event.preventDefault();
                if (currentIndex < this.rows.length - 1) {
                    const nextId = this.rows[currentIndex + 1].getAttribute('data-id');
                    @this.setActiveRow(nextId);
                }
                break;
            case 'ArrowUp':
                event.preventDefault();
                if (currentIndex > 0) {
                    const prevId = this.rows[currentIndex - 1].getAttribute('data-id');
                    @this.setActiveRow(prevId);
                }
                break;
            case 'Enter':
                event.preventDefault();
                if (this.activeRow) {
                    @this.handleEditRow({ id: this.activeRow });
                }
                break;
            case 'Insert':
                event.preventDefault();
                @this.dispatch('openCreateModal');
                break;
        }
    },
    confirmDelete(id) {
        console.log('Deleting state with ID:', id);
        Swal.fire({
            title: 'Emin misiniz?',
            text: 'Bu kaydı silmek istediğinize emin misiniz?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.dispatch('deleteRow', { id });
            }
        });
    }
}" class="flex flex-col h-[calc(100vh-4rem)] bg-white shadow-sm rounded-lg border"
    x-on:keydown.window="handleKeyDown($event)">
    <!-- Standart Tablo Butonları -->
    <div class="flex items-center space-x-2 px-4 py-2 bg-white border-b">
        <button type="button" class="action-md" title="Yeni" @click="@this.dispatch('openCreateModal')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </button>
        <button type="button" class="action-md" title="Düzenle"
            @if ($activeRow) @click="@this.handleEditRow({ id: {{ $activeRow }} })" @endif>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </button>
        <button type="button" class="action-md" title="Sil"
            @if ($activeRow) @click="confirmDelete({{ $activeRow }})" @endif>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
        <button type="button" class="action-md" title="Seç"
            @if ($activeRow) @click="@this.dispatch('selectRow', { id: {{ $activeRow }} })" @endif>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </button>
        <button type="button" class="action-md" title="Yenile" @click="@this.dispatch('refreshTable')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
        </button>
        <button type="button" class="action-md" title="Yazdır">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
        </button>
        <button type="button" class="action-md" title="Kopyala">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
            </svg>
        </button>
        <button type="button" class="action-md" title="Dışarı Aktar">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </button>
    </div>

    <!-- Arama ve Sayfalama Kontrolleri -->
    <div class="px-4 py-2 bg-white border-b">
        <div class="flex justify-between items-center">
            <select wire:model.live="perPage" class="select-xs">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>

            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Ara..."
                    class="pl-8 pr-3 py-1 text-xs w-64 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablo İçeriği -->
    <div class="flex-1 min-h-0 overflow-auto relative">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 sticky top-0 z-10">
                <tr>
                    @foreach ($columns as $key => $column)
                        <th scope="col"
                            class="th-xs text-left font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('{{ $key }}')">
                            <div class="flex items-center space-x-1">
                                <span>{{ $column }}</span>
                                <span class="text-gray-400">
                                    @if ($sortField === $key)
                                        @if ($sortDirection === 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @else
                                        ↕
                                    @endif
                                </span>
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    <!-- Pagination Bilgisi -->
    <div class="mt-auto px-4 py-2 bg-gray-50 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-xs text-gray-700">
                {{ $records->firstItem() ?? 0 }} ile {{ $records->lastItem() ?? 0 }} arası gösteriliyor, toplam
                {{ $records->total() }} kayıt
            </div>
            <div>
                {{ $records->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .btn-icon {
        @apply inline-flex items-center p-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
    }
</style>
