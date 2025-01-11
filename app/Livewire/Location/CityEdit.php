<?php

namespace App\Livewire\Location;

use App\Models\Lokasyon\City;
use Livewire\Component;

class CityEdit extends Component
{
    public $showModal = false;
    public $cityId;

    public $form = [
        'state_id' => '',
        'Code' => '',
        'Name' => '',
        'Status' => null,
        'Description' => ''
    ];

    protected $listeners = [
        'editCity' => 'edit',
        'state-selected' => 'handleStateSelected'
    ];

    protected function rules()
    {
        return [
            'form.state_id' => 'required|exists:states,id',
            'form.Code' => 'required|string|max:10|unique:cities,Code,' . $this->cityId,
            'form.Name' => 'required|string|max:255|unique:cities,Name,' . $this->cityId,
            'form.Status' => 'required|boolean',
            'form.Description' => 'nullable|string'
        ];
    }

    protected $messages = [
        'form.state_id.required' => 'İl seçimi zorunludur.',
        'form.Code.required' => 'İlçe kodu zorunludur.',
        'form.Code.unique' => 'Bu ilçe kodu zaten kullanılmaktadır.',
        'form.Name.required' => 'İlçe adı zorunludur.',
        'form.Name.unique' => 'Bu ilçe adı zaten kullanılmaktadır.',
        'form.Status.required' => 'Durum seçimi zorunludur.'
    ];

    public function edit($id)
    {
        $city = City::findOrFail($id);
        $this->cityId = $id;
        $this->form = [
            'state_id' => $city->state_id,
            'Code' => $city->Code,
            'Name' => $city->Name,
            'Status' => $city->Status ? "1" : "0",
            'Description' => $city->Description
        ];
        $this->showModal = true;
    }

    public function handleStateSelected($stateId)
    {
        if ($this->form['state_id'] != $stateId) {
            $this->form['state_id'] = $stateId;
            $this->form['Name'] = '';
        }
    }

    public function save()
    {
        try {
            $this->validate();

            $city = City::findOrFail($this->cityId);
            $city->update([
                'state_id' => $this->form['state_id'],
                'Code' => $this->form['Code'],
                'Name' => $this->form['Name'],
                'Status' => (bool)$this->form['Status'],
                'Description' => $this->form['Description']
            ]);

            $this->dispatch('cityUpdated');
            $this->dispatch('show-message', [
                'type' => 'success',
                'message' => 'İlçe başarıyla güncellendi.'
            ]);

            $this->showModal = false;
            $this->reset(['form', 'cityId']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = '';
            foreach ($e->validator->errors()->all() as $error) {
                $errorMessages .= $error . '<br>';
            }

            $this->dispatch('show-message', [
                'type' => 'error',
                'message' => $errorMessages
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'type' => 'error',
                'message' => 'İlçe güncellenirken bir hata oluştu.'
            ]);
        }
    }

    public function delete()
    {
        try {
            City::find($this->cityId)->delete();
            $this->dispatch('city-deleted');
            $this->dispatch('show-message', [
                'type' => 'success',
                'message' => 'İlçe başarıyla silindi.'
            ]);
            $this->showModal = false;
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'type' => 'error',
                'message' => 'İlçe silinirken bir hata oluştu.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.location.city-edit');
    }
}
