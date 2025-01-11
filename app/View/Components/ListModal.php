<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListModal extends Component
{
    public function __construct(
        public int $modalWidth,
        public int $modalHeight
    ) {}

    public function render()
    {
        return view('components.list-modal');
    }
}
