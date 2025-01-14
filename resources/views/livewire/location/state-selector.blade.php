<div>
    <x-list-modal wire:model="showModal" modalTitle="İl Seçimi" :modalWidth="400" :modalHeight="800" :manualWidth="true">
        <div class="flex flex-col h-full" wire:key="state-selector-{{ now() }}">
            <!-- Table -->
            <div class="flex-1 min-h-0">
                <x-data-table :records="$states" :columns="$columns" :sort-field="$sortField" :sort-direction="$sortDirection" :active-row="$activeRow">
                    @foreach ($states as $state)
                        <tr wire:key="state-{{ $state->id }}" data-id="{{ $state->id }}" tabindex="0"
                            wire:click="@this.call('TableFunctions::handleRowClick', $this, {{ $state->id }})"
                            x-on:dblclick="@this.call('TableFunctions::handleEnterKey', $this, {{ $state->id }})"
                            @keydown.enter.prevent="@this.call('TableFunctions::handleEnterKey', $this, {{ $state->id }})"
                            @keydown.up.prevent="@this.call('TableFunctions::handleKeyDown', $this, {{ $loop->index > 0 ? $states[$loop->index - 1]->id : $state->id }}, 'up')"
                            @keydown.down.prevent="@this.call('TableFunctions::handleKeyDown', $this, {{ !$loop->last ? $states[$loop->index + 1]->id : $state->id }}, 'down')"
                            class="hover:bg-gray-50 focus:outline-none {{ $activeRow == $state->id ? 'bg-blue-50' : '' }}">
                            <td class="td-xs whitespace-nowrap text-center">{{ $state->Code }}</td>
                            <td class="td-xs whitespace-nowrap">{{ $state->Name }}</td>
                        </tr>
                    @endforeach
                </x-data-table>
            </div>
        </div>
    </x-list-modal>
</div>
