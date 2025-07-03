<?php

namespace App\Livewire;

use App\Models\Pasien;
use Livewire\Component;

class ShowPasien extends Component
{
    public $id;
    public Pasien $pasien;
    public $filterTanggal;
    public $filterStatus;
    public $showingModalId = null; // null kalau tidak tampilkan modal
    public function showModal($id)
    {
        $this->showingModalId = $id;
    }

    public function closeModal()
    {
        $this->showingModalId = null;
    }

    public function mount($id)
    {
        $this->pasien = Pasien::with(['transaksis.listTransaksis.layanan'])->findOrFail($id);
    }

    public function render()
    {
        $this->pasien = Pasien::with(['transaksis.listTransaksis.layanan'])->findOrFail($this->id);

        $transaksis = $this->pasien->transaksis
            ->when($this->filterTanggal, fn($q) => $q->filter(fn($trx) =>
            $trx->waktu->format('Y-m-d') == $this->filterTanggal))
            ->when($this->filterStatus != null && $this->filterStatus !== '', fn($q) => $q->filter(fn($trx) =>
            $trx->status == (int)$this->filterStatus));

        $this->pasien->setRelation('transaksis', $transaksis);

        return view('livewire.show-pasien');
    }
}
