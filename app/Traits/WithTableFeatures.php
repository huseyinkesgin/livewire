<?php

namespace App\Traits;

trait WithTableFeatures
{
    public $perPage = 10;
    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function getQuery()
    {
        return $this->model::query()
            ->when($this->search, function ($query) {
                $searchableFields = $this->getSearchableFields();
                $query->where(function ($subQuery) use ($searchableFields) {
                    foreach ($searchableFields as $field) {
                        $subQuery->orWhere($field, 'like', '%' . $this->search . '%');
                    }
                });
            })
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortDirection);
            });
    }

    protected function getSearchableFields()
    {
        return property_exists($this, 'searchableFields')
            ? $this->searchableFields
            : ['name'];
    }

    public function handleEditRow($id)
    {
        $this->dispatch('edit-row', $id);
    }
}
