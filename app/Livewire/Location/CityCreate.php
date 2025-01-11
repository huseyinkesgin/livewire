<?php

namespace App\Livewire\Location;

use App\Models\Lokasyon\City;
use Livewire\Component;

class CityCreate extends Component
{
    public $showModal = false;

    public $form = [
        'state_id',
        'Code' => '',
        'Name' => '',
        'Status' => 1,
        'Description' => ''
    ];

    protected $listeners = [
        'openCreateModal' => 'openModal',
        'state-selected' => 'handleStateSelected'
    ];

    protected function rules()
    {
        return [
            'form.state_id' => 'required|exists:states,id',
            'form.Code' => 'required|string|max:10|unique:cities,Code',
            'form.Name' => 'required|string|max:255|unique:cities,Name',
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

    public function mount()
    {
        $this->form['Code'] = City::generateCode();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function resetForm()
    {
        $this->form = [
            'state_id' => '',
            'Code' => City::generateCode(),
            'Name' => '',
            'Status' => 1,
            'Description' => ''
        ];
    }

    public function handleStateSelected($stateId)
    {
        $this->form['state_id'] = $stateId;
        if ($this->form['Name']) {
            $this->form['Name'] = '';
        }
    }

    public function save()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $messages = [];
            foreach ($e->validator->errors()->all() as $error) {
                $messages[] = $error;
            }

            $this->dispatch('show-message', [
                'message' => implode("\n", $messages),
                'type' => 'error'
            ]);
            return;
        }

        try {
            City::create([
                'state_id' => $this->form['state_id'],
                'Code' => $this->form['Code'],
                'Name' => $this->form['Name'],
                'Status' => (bool)$this->form['Status'],
                'Description' => $this->form['Description']
            ]);

            $this->dispatch('city-created');
            $this->dispatch('show-message', [
                'message' => 'İlçe başarıyla kaydedildi.',
                'type' => 'success'
            ]);

            $this->showModal = false;
            $this->resetForm();
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'message' => 'İlçe kaydedilirken bir hata oluştu.',
                'type' => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.location.city-create');
    }
}
