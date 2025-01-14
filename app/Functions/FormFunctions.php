<?php

namespace App\Functions;

class FormFunctions
{
    // Form Modal Events
    public static function handleFormSave($component)
    {
        $savedId = $component->save();
        if ($savedId) {
            $component->showModal = false;
            $component->dispatch('recordSaved', ['id' => $savedId]);
        }
    }

    public static function handleFormCancel($component)
    {
        $component->resetForm();
        $component->showModal = false;
    }

    public static function handleFormKeyPress($component, $key)
    {
        switch ($key) {
            case 'ctrl+s':
                $component->save();
                break;
            case 'escape':
                self::handleFormCancel($component);
                break;
            case 'f4':
                self::handleListOpen($component);
                break;
        }
    }

    // List Modal Events
    public static function handleListOpen($component, $type = null)
    {
        $methodName = "open{$type}ListForm";
        if (method_exists($component, $methodName)) {
            $component->$methodName();
        }
    }

    public static function handleListClose($component)
    {
        $component->showModal = false;
    }

    // Form Field Events
    public static function handleFieldFocus($component, $field)
    {
        $component->focusField = $field;
    }

    public static function handleFieldBlur($component, $field)
    {
        $component->focusField = null;
    }

    public static function handleFieldKeyPress($component, $field, $key)
    {
        switch ($key) {
            case 'f4':
                if ($field === 'state_id') {
                    self::handleListOpen($component, 'State');
                } elseif ($field === 'city_id') {
                    self::handleListOpen($component, 'City');
                }
                break;
        }
    }
}
