<?php

namespace App\Livewire;

use App\Models\Pasien;
use Livewire\Component;

class ShowPasien extends Component
{
    public $id;
    public Pasien $pasien;

    public function mount($id)
    {
        $this->pasien = Pasien::with(['transaksis.listTransaksis.layanan'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.show-pasien');
    }
}
