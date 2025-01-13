<div class="flex flex-col h-[calc(100vh-4rem)]">
    <!-- Tablo -->
    <div class="flex-1 min-h-0">
        <x-data-table
            :records="$states"
            :columns="$columns"
            :sort-field="$sortField"
            :sort-direction="$sortDirection"
            :active-row="$activeRow">
            @foreach($states as $index => $state)
                <tr data-id="{{ $state->id }}"
                    tabindex="0"
                    @keydown="handleKeyDown($event)"
                    wire:click="setActiveRow({{ $state->id }})"
                    @dblclick="handleRowDoubleClick('{{ $state->id }}')"
                    class="hover:bg-gray-50 focus:outline-none {{ $activeRow == $state->id ? 'bg-blue-50' : '' }}">
                    <td class="td-xs whitespace-nowrap text-center">
                        {{ $state->Code }}
                    </td>
                    <td class="td-xs whitespace-nowrap">
                        {{ $state->Name }}
                    </td>
                    <td class="td-xs whitespace-nowrap">
                        {{ $state->created_at->format('d.m.Y H:i') }}
                    </td>
                    <td class="td-xs whitespace-nowrap">
                        {{ $state->updated_at->format('d.m.Y H:i') }}
                    </td>
                    <td class="td-xs whitespace-nowrap">
                        {{ $state->Description }}
                    </td>
                </tr>
            @endforeach
        </x-data-table>
    </div>

    <!-- Modal Komponentleri -->
    <livewire:location.state-create />
    <livewire:location.state-edit />
</div>
