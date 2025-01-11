<?php

namespace App\Livewire\Location;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Lokasyon\State;

class StateSelector extends Component
{
    use WithPagination;

    public $showModal = false;
    public $search = '';
    public $selectedId = null;
    public $selectedName = '';
    public $modalWidth = 1200;
    public $modalHeight = 800;
    public $activeRow = null;

    protected $listeners = ['rowSelected' => 'handleRowSelected'];

    public function mount($selectedId = null)
    {
        $this->selectedId = $selectedId;
        if ($selectedId) {
            $state = State::find($selectedId);
            if ($state) {
                $this->selectedName = $state->Name;
            }
        }
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function handleRowSelected($id)
    {
        $this->activeRow = $id;
    }

    public function select($id = null)
    {
        $stateId = $id ?? $this->activeRow;

        if ($stateId) {
            $state = State::find($stateId);
            if ($state) {
                $this->selectedId = $state->id;
                $this->selectedName = $state->Name;
                $this->dispatch('state-selected', $state->id);
                $this->showModal = false;
            }
        }
    }

    public function delete()
    {
        if (!$this->activeRow) {
            $this->dispatch('show-message', [
                'message' => 'Lütfen silinecek ili seçin.',
                'type' => 'error'
            ]);
            return;
        }

        $state = State::find($this->activeRow);
        if (!$state) {
            $this->dispatch('show-message', [
                'message' => 'İl bulunamadı.',
                'type' => 'error'
            ]);
            return;
        }

        try {
            // İl'e bağlı ilçe var mı kontrol et
            if ($state->cities()->count() > 0) {
                $this->dispatch('show-message', [
                    'message' => 'Bu ile bağlı ilçeler bulunmaktadır. Önce ilçeleri silmelisiniz.',
                    'type' => 'error'
                ]);
                return;
            }

            $state->delete();
            $this->activeRow = null;
            $this->dispatch('state-deleted');
            $this->dispatch('show-message', [
                'message' => 'İl başarıyla silindi.',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'message' => 'İl silinirken bir hata oluştu.',
                'type' => 'error'
            ]);
        }
    }

    public function create()
    {
        $this->dispatch('open-state-create-modal');
    }

    public function refresh()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $states = State::query()
            ->when($this->search, function ($query) {
                $query->where('Name', 'like', '%' . $this->search . '%')
                    ->orWhere('Code', 'like', '%' . $this->search . '%');
            })
            ->orderBy('Code')
            ->paginate(10);

        return view('livewire.location.state-selector', [
            'states' => $states
        ]);
    }
}
