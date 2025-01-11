<div>
    <x-form-modal 
        wire:model="showModal"
        :modalWidth="300"
        :modalHeight="350"
    >
        <div class="space-y-3">
            <div class="grid grid-cols-12 items-center gap-4">
                <x-label for="Code" value="İlçe Kodu" class="col-span-3 text-right label-xs" />
                <div class="col-span-9">
                    <x-input id="Code" type="text" class="w-full input-xs" wire:model="form.Code" readonly />
                    @error('form.Code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-12 items-center gap-4">
                <x-label for="state_id" value="İl" class="col-span-3 text-right label-xs" />
                <div class="col-span-9">
                    <livewire:location.state-selector wire:model="form.state_id" />
                    @error('form.state_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-12 items-center gap-4">
                <x-label for="Name" value="İlçe Adı" class="col-span-3 text-right label-xs" />
                <div class="col-span-9">
                    <x-input id="Name" type="text" class="w-full input-xs" wire:model="form.Name" />
                    @error('form.Name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-12 items-center gap-4">
                <x-label for="Status" value="Durum" class="col-span-3 text-right label-xs" />
                <div class="col-span-9">
                    <select id="Status" class="w-full select-xs border-gray-300 rounded-md shadow-sm" wire:model.live="form.Status">
                        <option value="">Seçiniz</option>
                        <option value="1">Aktif</option>
                        <option value="0">Pasif</option>
                    </select>
                    @error('form.Status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-12 items-start gap-4">
                <x-label for="Description" value="Açıklama" class="col-span-3 text-right label-xs pt-2" />
                <div class="col-span-9">
                    <textarea id="Description" rows="3" class="w-full input-xs border-gray-300 rounded-md shadow-sm" wire:model="form.Description"></textarea>
                    @error('form.Description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <button type="button" class="btn btn-cancel mr-2" wire:click="$set('showModal', false)">
                İptal
            </button>
            <button type="button" class="btn btn-save" wire:click="save">
                Kaydet
            </button>
        </x-slot>
    </x-form-modal>
</div> 