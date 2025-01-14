<div>

    <x-form-modal wire:model="showModal" modalTitle="İlçe Ekle" mode="create" :modalWidth="350" :modalHeight="280">
        <div class="space-y-1">
            <div class="grid grid-cols-12 items-center gap-4">
                <x-label for="Code" value="İlçe Kodu" class="col-span-3 text-right label-xs" />
                <div class="col-span-9">
                    <x-input id="Code" type="text" class="w-full input-xs" wire:model="form.Code" x-ref="code"
                        readonly />
                </div>
            </div>

            <div class="grid grid-cols-12 items-center gap-4">
                <x-label for="state_id" value="İl" class="col-span-3 text-right label-xs" />
                <div class="col-span-9">
                    <div class="flex gap-1">
                        <x-input type="text" class="w-full input-xs" wire:model="selectedStateName" readonly
                            placeholder="İl seçiniz..." />
                        <button type="button"
                            class="inline-flex items-center px-2 border border-gray-300 bg-gray-50 rounded-md shadow-sm hover:bg-gray-100"
                            wire:click="openStateSelector" @keydown.enter.prevent="$wire.openStateSelector()"
                            @keydown.f4.prevent="$wire.openStateSelector()" tabindex="0">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </button>
                    </div>
                    @error('form.state_id')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-12 items-center gap-4">
                <x-label for="Name" value="İlçe Adı" class="col-span-3 text-right label-xs" />
                <div class="col-span-9">
                    <x-input id="Name" type="text" class="w-full input-xs" wire:model="form.Name" />
                </div>
            </div>

            <div class="grid grid-cols-12 items-center gap-4">
                <x-label for="Status" value="Durum" class="col-span-3 text-right label-xs" />
                <div class="col-span-9">
                    <select id="Status" class="w-full select-xs" wire:model="form.Status">
                        <option value="">Seçiniz</option>
                        <option value="1">Aktif</option>
                        <option value="0">Pasif</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-12 items-start gap-4">
                <x-label for="Description" value="Açıklama" class="col-span-3 text-right label-xs pt-2" />
                <div class="col-span-9">
                    <x-textarea id="Description" rows="3" class="w-full input-xs" wire:model="form.Description" />
                </div>
            </div>
        </div>
    </x-form-modal>

    <livewire:location.state-selector />
</div>
