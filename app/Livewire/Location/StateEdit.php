<?php

namespace App\Livewire\Location;

use Livewire\Component;
use App\Models\Lokasyon\State;
use Illuminate\Support\Facades\Validator;

class StateEdit extends Component
{
    public $showModal = false;
    public $stateId;
    public $form = [
        'Code' => '',
        'Name' => '',
        'Status' => '',
        'Description' => ''
    ];

    protected $listeners = ['edit-state' => 'edit'];

    public function edit($id)
    {
        $state = State::findOrFail($id);
        $this->stateId = $state->id;
        $this->form = [
            'Code' => $state->Code,
            'Name' => $state->Name,
            'Status' => $state->Status ? "1" : "0",
            'Description' => $state->Description
        ];
        $this->showModal = true;
    }

    public function save()
    {
        try {
            $state = State::findOrFail($this->stateId);

            $validated = Validator::make($this->form, [
                'Code' => 'required|string|max:10|unique:states,Code,' . $this->stateId,
                'Name' => 'required|string|max:255|unique:states,Name,' . $this->stateId,
                'Status' => 'required|in:0,1',
                'Description' => 'nullable|string|max:1000'
            ])->validate();

            $state->update($validated);

            $this->dispatch('show-message', [
                'type' => 'success',
                'message' => 'İl başarıyla güncellendi.'
            ]);

            $this->showModal = false;
            $this->dispatch('refreshTable');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('show-message', [
                'type' => 'error',
                'message' => collect($e->errors())->flatten()->implode('<br>')
            ]);
        }
    }

    public function updated($property)
    {
        if ($property === 'showModal' && !$this->showModal) {
            $this->dispatch('closeModal');
        }
    }

    public function render()
    {
        return view('livewire.location.state-edit');
    }
}
