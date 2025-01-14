<div class="flex flex-col h-[calc(100vh-4rem)]">
    <!-- Tablo -->
    <div class="flex-1 min-h-0">
        <x-data-table :records="$cities" :columns="$columns" :sort-field="$sortField" :sort-direction="$sortDirection" :active-row="$activeRow">
            @foreach ($cities as $city)
                <tr data-id="{{ $city->id }}" tabindex="0" wire:click="setActiveRow({{ $city->id }})"
                    wire:dblclick="handleEditRow({{ $city->id }})"
                    class="hover:bg-gray-50 focus:outline-none {{ $activeRow == $city->id ? 'bg-blue-50' : '' }}">
                    <td class="td-xs whitespace-nowrap text-center">
                        {{ $city->Code }}
                    </td>
                    <td class="td-xs whitespace-nowrap">
                        {{ $city->state->Name }}
                    </td>
                    <td class="td-xs whitespace-nowrap">
                        {{ $city->Name }}
                    </td>
                    <td class="td-xs whitespace-nowrap text-center">
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $city->Status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $city->Status ? 'Aktif' : 'Pasif' }}
                        </span>
                    </td>
                    <td class="td-xs whitespace-nowrap">
                        {{ $city->Description }}
                    </td>
                    <td class="td-xs whitespace-nowrap">
                        {{ $city->created_at->format('d.m.Y H:i') }}
                    </td>
                    <td class="td-xs whitespace-nowrap">
                        {{ $city->updated_at->format('d.m.Y H:i') }}
                    </td>
                </tr>
            @endforeach
        </x-data-table>
    </div>

    <livewire:location.city-create />
    <livewire:location.city-edit />
</div>
