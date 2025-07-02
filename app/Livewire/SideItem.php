<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class SideItem extends Component
{
    public $href;
    public $title;
    public $active;
    public $icon;

    public function mount()
    {

        // test
        $this->active = Str::startsWith(request()->getPathInfo() . '/', rtrim($this->href, '/') . '/');
    }

    public function render()
    {
        return view('livewire.side-item');
    }
}
