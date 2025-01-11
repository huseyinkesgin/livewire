<div class="flex flex-col">
    <!-- Tablo Kontrolleri -->
    <div class="flex justify-between items-center p-4 bg-white border-b">
        <!-- Sol Kontroller -->
        <div class="flex items-center space-x-2">
            <livewire:location.state-create />
            <select wire:model.live="perPage" class="border-gray-300 rounded-md shadow-sm text-sm">
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
                    class="pl-8 pr-3 py-2 w-64 border-gray-300 rounded-md shadow-sm text-sm">
                <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablo -->
    <x-data-table 
        :records="$states" 
        :columns="$columns"
        :sort-field="$sortField"
        :sort-direction="$sortDirection">
        @foreach($states as $index => $state)
            <tr data-id="{{ $state->id }}"
                tabindex="0"
                @keydown="handleKeyDown($event)"
                @click="handleRowClick('{{ $state->id }}', {{ $index }})"
                @dblclick="handleRowDoubleClick('{{ $state->id }}')"
                class="hover:bg-gray-50 focus:outline-none focus:bg-blue-50">
                <td class="td-xs whitespace-nowrap text-gray-900">
                    {{ $state->Code }}
                </td>
                <td class="td-xs whitespace-nowrap text-gray-900">
                    {{ $state->Name }}
                </td>
                <td class="td-xs whitespace-nowrap text-gray-500">
                    {{ $state->created_at->format('d.m.Y H:i') }}
                </td>
                <td class="td-xs whitespace-nowrap text-gray-500">
                    {{ $state->updated_at->format('d.m.Y H:i') }}
                </td>
                <td class="td-xs whitespace-nowrap text-gray-500">
                    {{ $state->Description }}
                </td>
            </tr>
        @endforeach
    </x-data-table>

    <!-- Modal Komponentleri -->
    <livewire:location.state-edit />
</div>
