<div>
    <!-- Input Field -->
    <div class="relative">
        <div class="flex">
            <input 
                type="text" 
                class="w-full input-xs border-gray-300 rounded-l-md shadow-sm" 
                placeholder="İl seçiniz..."
                wire:model="selectedName"
                readonly
            >
            <button 
                type="button" 
                class="inline-flex items-center px-2 border border-l-0 border-gray-300 bg-gray-50 rounded-r-md shadow-sm hover:bg-gray-100"
                wire:click="openModal"
            >
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Add State Button -->
   

    @teleport('body')
        <x-list-modal 
            wire:model="showModal"
            :modalWidth="600"
            :modalHeight="475"
        >
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <x-input type="text" wire:model.live="search" placeholder="Ara..." class="input-xs" />
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">İl Kodu</th>
                                <th class="px-4 py-2">İl Adı</th>
                                <th class="px-4 py-2">Oluşturma Tarihi</th>
                                <th class="px-4 py-2">Güncelleme Tarihi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($states as $state)
                                <tr 
                                    wire:key="{{ $state->id }}"
                                    data-id="{{ $state->id }}"
                                    tabindex="0"
                                    wire:click="handleRowSelected({{ $state->id }})"
                                    x-on:dblclick="$wire.select({{ $state->id }})"
                                    :class="{
                                        'bg-blue-50': activeRow === {{ $state->id }},
                                        'hover:bg-gray-50': activeRow !== {{ $state->id }}
                                    }"
                                    class="border-b cursor-pointer focus:outline-none focus:bg-blue-50"
                                >
                                    <td class="td-xs">{{ $state->Code }}</td>
                                    <td class="td-xs">{{ $state->Name }}</td>
                                    <td class="td-xs">{{ $state->created_at }}</td>
                                    <td class="td-xs">{{ $state->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $states->links() }}
                </div>
            </div>
        </x-list-modal>
    @endteleport
</div> 