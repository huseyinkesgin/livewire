<?php

namespace App\Functions;

class SelectFunctions
{
    public static function handleSelection($component, $id, $type)
    {
        $methodName = "handle{$type}Selected";
        if (method_exists($component, $methodName)) {
            $component->$methodName($id);
        }
    }

    public static function openSelector($component, $type = null)
    {
        $methodName = $type ? "open{$type}Modal" : "openModal";
        if (method_exists($component, $methodName)) {
            $component->$methodName();
        }
    }

    public static function closeSelector($component)
    {
        $component->showModal = false;
    }

    public static function handleKeyboardNavigation($component, $key, $currentId, $type)
    {
        switch ($key) {
            case 'arrowup':
            case 'arrowdown':
                // Implement navigation logic
                break;
            case 'enter':
                self::handleSelection($component, $currentId, $type);
                break;
        }
    }
}