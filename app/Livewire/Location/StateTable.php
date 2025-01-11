<?php

namespace App\Livewire\Location;

use App\Models\State;
use App\Livewire\Components\BaseTableComponent;

class StateTable extends BaseTableComponent
{
    protected $model = State::class;
    protected $searchableFields = ['Code', 'Name', 'Description'];
    public $sortField = 'Code';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'Code'],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 10],
    ];

    protected $listeners = [
        'refreshTable' => '$refresh',
        'state-created' => 'handleStateCreated'
    ];

    public function handleStateCreated($stateId)
    {
        $this->dispatch('focusRow', $stateId);
    }

    public function handleEditRow($id)
    {
        $this->dispatch('edit-state', $id);
    }

    public function render()
    {
        return view('livewire.location.state-table', [
            'states' => $this->records,
            'columns' => [
                'Code' => 'İl Kodu',
                'Name' => 'İl Adı',
                'created_at' => 'Oluşturulma Tarihi',
                'updated_at' => 'Güncellenme Tarihi',
                'Description' => 'Açıklama'
            ]
        ]);
    }
}
