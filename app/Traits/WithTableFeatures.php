<?php

namespace App\Traits;

trait WithTableFeatures
{
    public $perPage = 20;
    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $activeRow = null;

    public function setActiveRow($id)
    {
        $this->activeRow = $id;
        $this->dispatch('row-activated', ['id' => $id]);
    }

    public function handleRowClick($id)
    {
        $this->setActiveRow($id);
    }

    public function handleEditRow($params)
    {
        $id = is_array($params) ? $params['id'] : $params;
        $this->setActiveRow($id);
        $this->dispatch('editRow', ['id' => $id]);
    }

    public function handleDeleteRow($params)
    {
        $id = is_array($params) ? $params['id'] : $params;
        $this->setActiveRow($id);
        $this->dispatch('deleteRow', ['id' => $id]);
    }

    public function handleSelectRow($params)
    {
        $id = is_array($params) ? $params['id'] : $params;
        $this->setActiveRow($id);
        $this->dispatch('selectRow', ['id' => $id]);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'desc';
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
}
