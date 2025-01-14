<?php

namespace App\Livewire\Location;

use App\Models\Lokasyon\State;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class StateCreate extends Component
{
    public $showModal = false;

    public $form = [
        'Code' => '',
        'Name' => '',
        'Status' => "1",
        'Description' => ''
    ];

    protected $listeners = [
        'openCreateModal' => 'openCreateModal'
    ];

    public function mount()
    {
        $this->generateCode();
    }

    public function openCreateModal()
    {
        $this->form = [
            'Code' => State::generateCode(),
            'Name' => '',
            'Status' => 1,
            'Description' => ''
        ];
        $this->showModal = true;
    }

    public function generateCode()
    {
        $this->form['Code'] = State::generateCode();
    }

    public function save()
    {
        try {
            $validated = Validator::make($this->form, [
                'Code' => 'required|string|max:10|unique:states,Code',
                'Name' => 'required|string|max:255|unique:states,Name',
                'Status' => 'required|in:0,1',
                'Description' => 'nullable|string|max:1000'
            ])->validate();

            $state = State::create($validated);

            $this->dispatch('show-message', [
                'type' => 'success',
                'message' => 'İl başarıyla eklendi.'
            ]);

            $this->showModal = false;
            $this->resetForm();

            $this->dispatch('state-created', $state->id)->to('location.state-table');
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
            'Code' => '',
            'Name' => '',
            'Status' => "1",
            'Description' => ''
        ];
        $this->generateCode();
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
        return view('livewire.location.state-create');
    }
}