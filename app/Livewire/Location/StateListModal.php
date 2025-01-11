<?php

namespace App\Livewire\Location;

use App\Models\Lokasyon\State;
use Livewire\Component;
use Livewire\WithPagination;

class StateListModal extends Component
{
    use WithPagination;

    public $showModal = false;
    public $search = '';
    public $perPage = 10;

    protected $listeners = ['openStateListModal' => 'openModal'];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function selectState($id, $name)
    {
        $this->dispatch('stateSelected', id: $id, name: $name);
        $this->showModal = false;
        $this->reset('search');
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $states = State::query()
            ->search($this->search)
            ->orderBy('Name')
            ->paginate($this->perPage);

        return view('livewire.location.state-list-modal', [
            'states' => $states
        ]);
    }
}
