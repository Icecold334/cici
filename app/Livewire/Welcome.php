<?php

namespace App\Livewire;

use Livewire\Component;

class Welcome extends Component
{
    public $layanans;
    public function booking()
    {
        return redirect()->to('/booking');
    }
    public function render()
    {
        return view('livewire.welcome');
    }
}
