<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithTableFeatures;

abstract class BaseTableComponent extends Component
{
    use WithPagination;
    use WithTableFeatures;

    protected $paginationTheme = 'tailwind';
    protected $model;
    protected $listeners = ['refreshTable' => '$refresh'];

    public function mount()
    {
        if (!isset($this->model)) {
            throw new \Exception('Model property must be set in table component.');
        }
    }

    public function getRecordsProperty()
    {
        return $this->getQuery()->paginate($this->perPage);
    }

    abstract public function render();
}
