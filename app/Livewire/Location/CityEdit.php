<?php

namespace App\Livewire\Location;

use App\Models\Lokasyon\City;
use Livewire\Component;

class CityEdit extends Component
{

    public function render()
    {
        return view('livewire.location.city-edit');
    }
}