<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Layanan;
use Livewire\Component;
use App\Models\Transaksi;
use App\Models\ListTransaksi;

class Booking extends Component
{
    public $nama, $no_hp, $tanggal, $alamat, $tlahir;
    public $layanan_id;
    public $disableSimpan;
    public $layanan_terpilih = [];
    public $showModal = false, $layanans;

    public function mount()
    {
        $this->checkSimpan();
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
                    'deskripsi' => $layanan->deskripsi,
                    'harga' => $layanan->harga,
                ];
            }
            $this->layanan_id = null;
        }
        $this->checkSimpan();
    }

    public function updated()
    {
        $this->checkSimpan();
    }

    public function checkSimpan()
    {
        $this->disableSimpan = empty($this->nama)
            || empty($this->no_hp)
            || empty($this->tanggal)
            || empty($this->tlahir)
            || empty($this->alamat)
            || count($this->layanan_terpilih) === 0;
    }
    public function removeLayanan($index)
    {
        unset($this->layanan_terpilih[$index]);
        $this->layanan_terpilih = array_values($this->layanan_terpilih);
        $this->checkSimpan();
    }
    public function resetForm()
    {
        $this->nama = '';
        $this->no_hp = '';
        $this->tanggal = '';
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
        $transaksi = Transaksi::create([
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'tlahir' => $this->tlahir,
            'nohp' => $this->no_hp,
            'waktu' => Carbon::parse($this->tanggal),
            'status' => 0,
        ]);


        foreach ($this->layanan_terpilih as $item) {
            ListTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'layanan_id' => $item['id'],
                'nama' => $item['nama'],
                'deskripsi' => $item['deskripsi'],
                'harga' => $item['harga'],
            ]);
        }

        $this->dispatch('booked', 'Booking berhasil disimpan!');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.booking', [
            'layanans' => Layanan::all()
        ]);
    }
}
