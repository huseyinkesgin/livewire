<?php

namespace App\Functions;

class TableFunctions
{
    // List Form Events (Seçim Modalı için)
    public static function handleListRowClick($component, $id)
    {
        $component->handleRowSelected($id);
    }

    public static function handleListDoubleClick($component, $id)
    {
        $component->select($id);
    }

    public static function handleListEnterKey($component, $id)
    {
        $component->select($id);
    }

    public static function handleListKeyDown($component, $id, $key)
    {
        switch ($key) {
            case 'up':
            case 'down':
                $component->handleRowSelected($id);
                break;
            case 'enter':
                $component->select($id);
                break;
            case 'escape':
                $component->showModal = false;
                break;
        }
    }

    // Data Table Events (Ana Tablo için)
    public static function handleDataRowClick($component, $id)
    {
        $component->handleRowSelected($id);
    }

    public static function handleDataDoubleClick($component, $id)
    {
        $component->edit($id);
    }

    public static function handleDataEnterKey($component, $id)
    {
        $component->edit($id);
    }

    public static function handleDataKeyDown($component, $id, $key)
    {
        switch ($key) {
            case 'up':
            case 'down':
                $component->handleRowSelected($id);
                break;
            case 'enter':
                $component->edit($id);
                break;
            case 'delete':
                $component->delete($id);
                break;
            case 'insert':
                $component->create();
                break;
        }
    }

    // Common Events (Ortak Kullanım)
    public static function handleSort($component, $field)
    {
        $component->sortBy($field);
    }

    public static function handleSearch($component, $term)
    {
        $component->search = $term;
    }

    public static function handlePageChange($component, $page)
    {
        $component->gotoPage($page);
    }
}