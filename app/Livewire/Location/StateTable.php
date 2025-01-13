<?php

namespace App\Livewire\Location;

use App\Models\State;
use App\Livewire\Components\BaseTableComponent;

class StateTable extends BaseTableComponent
{
    protected $model = State::class;
    protected $searchableFields = ['Code', 'Name', 'Description'];
    public $sortField = 'Code';
    public $activeRow = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'Code'],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 10],
    ];

    protected $listeners = [
        'refreshTable' => '$refresh',
        'state-created' => 'handleStateCreated',
        'closeModal' => 'handleModalClose',
        'openCreateModal' => 'handleOpenCreateModal',
        'editRow' => 'handleEditRow',
        'deleteRow' => 'deleteState'
    ];

    public function mount()
    {
        parent::mount();
        // İlk kayıt varsa onu aktif yap
        $firstRecord = $this->records->first();
        if ($firstRecord) {
            $this->activeRow = $firstRecord->id;
        }
    }

    public function handleStateCreated($stateId)
    {
        $this->activeRow = $stateId;
        $this->dispatch('focusRow', $stateId);
    }

    public function handleModalClose()
    {
        // Modal kapandığında aktif satırı sadece aktif satır yoksa değiştir
        if (!$this->activeRow) {
            $firstRecord = $this->records->first();
            if ($firstRecord) {
                $this->activeRow = $firstRecord->id;
            }
        }
    }

    public function handleEditRow($id = null)
    {
        if (is_array($id) && isset($id['id'])) {
            $id = $id['id'];
        }

        if ($id) {
            $this->activeRow = $id;
            $this->dispatch('edit-state', $id);
        }
    }

    public function deleteState($id)
    {
        try {
            $state = State::findOrFail($id);

            // İl'e bağlı ilçe var mı kontrol et
            if ($state->cities()->count() > 0) {
                $this->dispatch('show-message', [
                    'type' => 'error',
                    'message' => 'Bu ile bağlı ilçeler bulunmaktadır. Önce ilçeleri silmelisiniz.'
                ]);
                return;
            }

            $state->delete();

            $this->dispatch('show-message', [
                'type' => 'success',
                'message' => 'İl başarıyla silindi.'
            ]);

            // Silinen kayıt aktif satır ise, ilk kaydı aktif yap
            if ($this->activeRow == $id) {
                $firstRecord = $this->records->first();
                if ($firstRecord) {
                    $this->activeRow = $firstRecord->id;
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'type' => 'error',
                'message' => 'İl silinirken bir hata oluştu.'
            ]);
        }
    }

    public function handleOpenCreateModal()
    {
        $this->dispatch('openCreateModal')->to('location.state-create');
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


    public function setActiveRow($id)
    {
        $this->activeRow = $id;
    }

    public function handleDeleteRow($params)
    {
        if (isset($params['id'])) {
            $this->deleteState($params['id']);
        }
    }
}
