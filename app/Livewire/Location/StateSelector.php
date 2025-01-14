<?php

namespace App\Livewire\Location;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Lokasyon\State;
use App\Traits\WithTableFeatures;

class StateSelector extends Component
{
    use WithPagination;
    use WithTableFeatures;

    public $showModal = false;
    public $selectedId = null;
    public $selectedName = '';
    public $activeRow = null;

    protected $model = State::class;
    protected $searchableFields = ['Code', 'Name'];

    protected $listeners = [
        'openStateSelector' => 'openModal',
        'rowSelected' => 'handleRowSelected',
        'setActiveRow' => 'setActiveRow'
    ];

    public function mount()
    {
        $this->sortField = 'Code';
        $this->sortDirection = 'desc';
        $this->perPage = 20;

        // Set first state as active by default
        $firstState = State::orderBy('Code', 'desc')->first();
        if ($firstState) {
            $this->activeRow = $firstState->id;
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

    public function setActiveRow($id)
    {
        $this->activeRow = $id;
    }

    public function select($id = null)
    {
        $stateId = $id ?? $this->activeRow;

        if ($stateId) {
            $state = State::find($stateId);
            if ($state) {
                $this->dispatch('state-selected', $state->id);
                $this->showModal = false;
            }
        }
    }

    public function getRecordsProperty()
    {
        return $this->model::query()
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    foreach ($this->searchableFields as $field) {
                        $subQuery->orWhere($field, 'like', '%' . $this->search . '%');
                    }
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.location.state-selector', [
            'states' => $this->records,
            'columns' => [
                'Code' => 'İl Kodu',
                'Name' => 'İl Adı'
            ]
        ]);
    }
}
