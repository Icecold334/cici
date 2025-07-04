<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Pasien;
use Illuminate\Support\Str;

class ShowTransaksi extends Component
{
    public $id;
    public $transaksi;
    public $showPasienPicker = false;
    public $searchPasien = '';
    public $showKonfirmasiPasienLama = false;
    public $selectedPasienId = null;
    public function setSelectedPasien($id)
    {
        $this->selectedPasienId = $id;
        $this->showKonfirmasiPasienLama = true;
    }

    public function mount($id)
    {
        $this->fetch($id);
    }

    public function fetch($id)
    {
        $this->transaksi = Transaksi::with(['pasien', 'listTransaksis.layanan'])->findOrFail($id);
    }

    public function getFilteredPasienProperty()
    {
        return Pasien::query()
            ->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->searchPasien . '%')
                    ->orWhere('nohp', 'like', '%' . $this->searchPasien . '%')
                    ->orWhere('alamat', 'like', '%' . $this->searchPasien . '%');
            })
            ->orderBy('nama')
            ->limit(20)
            ->get();
    }

    public function lanjutStatus($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        if ($transaksi->status < 2) {
            $transaksi->status += 1;
            $transaksi->save();
        }
        $this->fetch($id);
        $this->dispatch('toast', title: 'Status transaksi dilanjutkan', icon: 'info');
    }

    public function batalkanTransaksi($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        if (in_array($transaksi->status, [0, 1])) {
            $transaksi->status = 4;
            $transaksi->save();
        }
        $this->fetch($id);
        $this->dispatch('toast', title: 'Transaksi dibatalkan', icon: 'warning');
    }

    public function selesaikanTransaksi($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        if ($transaksi->status == 2) {
            $transaksi->status = 3;
            $transaksi->save();
        }
        $this->fetch($id);
        $this->dispatch('toast', title: 'Transaksi selesai', icon: 'success');
    }

    public function konfirmasiBooking($tipe)
    {
        if ($this->transaksi->status !== 0) return;

        if ($tipe === 'baru') {
            $pasien = Pasien::create([
                'nama' => $this->transaksi->nama,
                'nohp' => $this->transaksi->nohp,
                'alamat' => $this->transaksi->alamat,
                'tlahir' => $this->transaksi->tlahir,
                'kode' => Str::uuid(),
            ]);

            $this->transaksi->pasien_id = $pasien->id;
            $this->transaksi->status = 1;
            $this->transaksi->save();
            $this->fetch($this->transaksi->id);
            $this->dispatch('toast', title: 'Transaksi dikonfirmasi sebagai pasien baru', icon: 'success');
        }
    }

    public function bukaPemilihanPasien()
    {
        $this->showPasienPicker = true;
    }

    public function konfirmasiPasienLamaFinal()
    {
        if (!$this->selectedPasienId || $this->transaksi->status !== 0) return;

        $pasien = Pasien::findOrFail($this->selectedPasienId);
        $this->transaksi->pasien_id = $pasien->id;
        $this->transaksi->status = 1;
        $this->transaksi->save();

        $this->showPasienPicker = false;
        $this->showKonfirmasiPasienLama = false;
        $this->selectedPasienId = null;
        $this->fetch($this->transaksi->id);
        $this->dispatch('toast', title: 'Transaksi dikonfirmasi dengan pasien lama', icon: 'success');
    }

    public function render()
    {
        return view('livewire.show-transaksi', [
            'filteredPasien' => $this->filteredPasien
        ]);
    }
}
