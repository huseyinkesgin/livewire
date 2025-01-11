<div class="flex flex-col h-[calc(100vh-9rem)]">
    <!-- Tablo Kontrolleri -->
    <div class="flex justify-between items-center p-2 bg-white border-b">
        <!-- Sol Kontroller -->
        <div class="flex items-center space-x-2">
            <button type="button" class="btn btn-add" wire:click="$dispatch('openCreateModal')">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                İlçe Ekle
            </button>

            <select wire:model.live="perPage" class="select-xs border-gray-300 rounded-md shadow-sm">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>

        <!-- Sağ Kontroller -->
        <div class="flex items-center space-x-2">
            <div class="relative">
                <input type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Ara..." 
                    class="input-xs pl-8 pr-3 w-64 border-gray-300 rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablo İçeriği -->
    <div class="flex-1 overflow-auto bg-white">
        <table class="table-bordered">
            <thead class="sticky top-0 z-10 bg-white">
                <tr>
                    <th class="th-xs text-center" style="width: 50px">İşlemler</th>
                    <th class="th-xs">İlçe Kodu</th>
                    <th class="th-xs">İl Adı</th>
                    <th class="th-xs">İlçe Adı</th>
                    <th class="th-xs">Durum</th>
                    <th class="th-xs">Açıklama</th>
                    <th class="th-xs">Oluşturulma Tarihi</th>
                    <th class="th-xs">Güncellenme Tarihi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cities as $city)
                <tr class="tr-hover cursor-pointer" wire:click="handleEditCity({{ $city->id }})">
                    <td class="td-xs text-center" onclick="event.stopPropagation()">
                        <button type="button" class="action-xs action-delete" wire:click="deleteCity({{ $city->id }})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </td>
                    <td class="td-xs text-center">{{ $city->Code }}</td>
                    <td class="td-xs">{{ $city->state->Name }}</td>
                    <td class="td-xs">{{ $city->Name }}</td>
                    <td class="td-xs text-center">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $city->Status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $city->Status ? 'Aktif' : 'Pasif' }}
                        </span>
                    </td>
                    <td class="td-xs">{{ $city->Description }}</td>
                    <td class="td-xs text-center">{{ $city->created_at ? $city->created_at->format('d.m.Y') : '-' }}</td>
                    <td class="td-xs text-center">{{ $city->updated_at ? $city->updated_at->format('d.m.Y') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="td-xs text-center text-gray-500">
                        Kayıt bulunamadı...
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Sayfalama -->
    <div class="p-2 bg-white border-t mt-auto">
        <div class="flex items-center justify-between">
            <div class="text-xs text-gray-700">
                {{ $cities->firstItem() ?? 0 }} ile {{ $cities->lastItem() ?? 0 }} arası gösteriliyor, toplam {{ $cities->total() }} kayıt
            </div>
            <div>
                {{ $cities->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Komponentleri -->
    <livewire:location.city-create />
    <livewire:location.city-edit />
</div> 