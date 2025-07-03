<?php

namespace App\Livewire;

use App\Models\Layanan;
use Livewire\Component;

class Booking extends Component
{
    public $nama, $no_hp, $tanggal, $jam;
    public $layanan_id;
    public $layanan_terpilih = [];
    public $showModal = false, $layanans;

    public function mount()
    {
        // $this->resetForm();
    }
    public function addLayanan()
    {
        if ($this->layanan_id && !in_array($this->layanan_id, array_column($this->layanan_terpilih, 'id'))) {
            $layanan = Layanan::find($this->layanan_id);
            if ($layanan) {
                $this->layanan_terpilih[] = [
                    'id' => $layanan->id,
                    'nama' => $layanan->nama,
                ];
            }
            $this->layanan_id = null;
        }
    }
    public function removeLayanan($index)
    {
        unset($this->layanan_terpilih[$index]);
        $this->layanan_terpilih = array_values($this->layanan_terpilih);
    }
    public function resetForm()
    {
        $this->nama = '';
        $this->no_hp = '';
        $this->tanggal = '';
        $this->jam = '';
    }

    public function showForm()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function simpan()
    {
        // Validasi + simpan transaksi
        // $this->validate([
        //     'nama' => 'required|string|max:255',
        //     'no_hp' => 'required|string|max:20',
        //     'tanggal' => 'required|date',
        //     'jam' => 'required',
        //     'layanan_ids' => 'required|array|min:1',
        // ]);

        // Simpan logic di sini

        $this->dispatch('alert', 'Booking berhasil disimpan!');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.booking', [
            'layanans' => Layanan::all()
        ]);
    }
}
