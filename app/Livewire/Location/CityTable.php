<?php

namespace App\Livewire\Location;

use App\Models\Lokasyon\City;
use Livewire\Component;
use Livewire\WithPagination;

class CityTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $perPage = 20;
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 20],
    ];

    protected $listeners = [
        'cityCreated' => '$refresh',
        'cityUpdated' => '$refresh'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function handleEditCity($id)
    {
        $this->dispatch('editCity', $id);
    }

    public function deleteCity($id)
    {
        City::destroy($id);
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'İlçe başarıyla silindi.'
        ]);
    }

    public function render()
    {
        $cities = City::query()
            ->with('state')
            ->search($this->search)
            ->orderBy('Code')
            ->paginate($this->perPage);

        return view('livewire.location.city-table', [
            'cities' => $cities
        ]);
    }
}
