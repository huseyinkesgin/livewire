<?php

namespace App\Livewire\Location;

use App\Models\Lokasyon\City;
use App\Livewire\Components\BaseTableComponent;

class CityTable extends BaseTableComponent
{
    protected $model = City::class;
    protected $searchableFields = ['Code', 'Name', 'Description'];
    public $sortField = 'Code';
    public $activeRow = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'Code'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 20],
    ];

    protected $listeners = [
        'refreshTable' => '$refresh',
        'city-created' => 'handleCityCreated',
        'closeModal' => 'handleModalClose',
        'openCreateModal' => 'handleOpenCreateModal',
        'editRow' => 'handleEditRow',
        'deleteRow' => 'deleteCity'
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

    public function handleCityCreated($cityId)
    {
        $this->activeRow = $cityId;
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
            $this->dispatch('edit-city', $id)->to('location.city-edit');
        }
    }

    public function deleteCity($id)
    {
        try {
            $city = City::findOrFail($id);
            $city->delete();

            $this->dispatch('show-message', [
                'type' => 'success',
                'message' => 'İlçe başarıyla silindi.'
            ]);

            // Silinen kayıt aktif satır ise, ilk kaydı aktif yap
            if ($this->activeRow == $id) {
                $firstRecord = $this->records->first();
                if ($firstRecord) {
                    $this->activeRow = $firstRecord->id;
                }
            }
        } catch (\Exception $e) {
            logger()->error('City deletion error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'id' => $id
            ]);

            $this->dispatch('show-message', [
                'type' => 'error',
                'message' => 'İlçe silinirken bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }

    public function handleOpenCreateModal()
    {
        $this->dispatch('openCreateModal')->to('location.city-create');
    }

    public function render()
    {
        return view('livewire.location.city-table', [
            'cities' => $this->records,
            'columns' => [
                'Code' => 'İlçe Kodu',
                'state.Name' => 'İl Adı',
                'Name' => 'İlçe Adı',
                'Status' => 'Durum',
                'Description' => 'Açıklama',
                'created_at' => 'Oluşturulma Tarihi',
                'updated_at' => 'Güncellenme Tarihi'
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
            $this->deleteCity($params['id']);
        }
    }

}