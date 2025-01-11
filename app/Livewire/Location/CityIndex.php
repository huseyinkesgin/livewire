<?php

namespace App\Livewire\Location;

use Livewire\Component;
use Livewire\Attributes\Title;

class CityIndex extends Component
{
    #[Title('İlçeler')]
    public function render()
    {
         return view('livewire.location.city-index');
    }
}