<?php

namespace App\Livewire\Location;

use App\Models\Lokasyon\City;
use App\Models\Lokasyon\State;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class CityCreate extends Component
{
    public $showModal = false;
    public $selectedStateName = '';

    public $form = [
        'state_id' => '',
        'Code' => '',
        'Name' => '',
        'Status' => "1",
        'Description' => ''
    ];

    protected $listeners = [
        'openCreateModal' => 'openCreateModal',
        'state-selected' => 'handleStateSelected'
    ];

    public function mount()
    {
        $this->form['Code'] = City::generateCode();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openStateSelector()
    {
        $this->dispatch('openStateSelector');
    }

    public function handleStateSelected($stateId)
    {
        $state = State::find($stateId);
        if ($state) {
            $this->form['state_id'] = $state->id;
            $this->selectedStateName = $state->Name;
        }
    }

    public function generateCode()
    {
        $this->form['Code'] = City::generateCode();
    }

    public function save()
    {
        try {
            $validated = Validator::make($this->form, [
                'Code' => 'required|string|max:10|unique:cities,Code',
                'Name' => 'required|string|max:255|unique:cities,Name',
                'Status' => 'required|in:0,1',
                'Description' => 'nullable|string|max:1000'
            ])->validate();

            $city = City::create($validated);

            $this->dispatch('show-message', [
                'type' => 'success',
                'message' => 'İlçe başarıyla eklendi.'
            ]);

            $this->showModal = false;
            $this->resetForm();

            $this->dispatch('city-created', $city->id)->to('location.city-table');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('show-message', [
                'type' => 'error',
                'message' => collect($e->errors())->flatten()->implode('<br>')
            ]);
        }
    }

    public function resetForm()
    {
        $this->form = [
            'state_id' => '',
            'Code' => City::generateCode(),
            'Name' => '',
            'Status' => "1",
            'Description' => ''
        ];
        $this->selectedStateName = '';
    }

    public function updated($property)
    {
        if ($property === 'showModal' && !$this->showModal) {
            $this->dispatch('closeModal');
            $this->resetForm();
        }
    }

    public function render()
    {
        return view('livewire.location.city-create');
    }
}
