<div>

    <x-form-modal
        wire:model="showModal"
        modalTitle="İl Ekle"
        mode="create"
        :modalWidth="350"
        :modalHeight="280"
    >
        <div class="space-y-1">
            <div class="grid grid-cols-12 items-center gap-4">
                <x-label for="Code" value="İl Kodu" class="col-span-3 text-right label-xs" />
                <div class="col-span-9">
                    <x-input id="Code" type="text" class="w-full input-xs" wire:model="form.Code" x-ref="code" readonly />
                </div>
            </div>

            <div class="grid grid-cols-12 items-center gap-4">
                <x-label for="Name" value="İl Adı" class="col-span-3 text-right label-xs" />
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
</div>
