<?php

namespace App\Livewire;

use App\Models\Pasien;
use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\ListTransaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateTransaksi extends Component
{
    public $pasien_id;
    public $layanan_id;
    public $waktu;
    public $list = [];

    public $formTambahPasien = false;

    public $nama;
    public $alamat;
    public $tlahir;
    public $nohp;

    public function mount()
    {
        $this->waktu = now()->format('Y-m-d\TH:i');
    }

    public function toggleFormPasien()
    {
        $this->formTambahPasien = !$this->formTambahPasien;
        if (!$this->formTambahPasien) {
            $this->nama = null;
            $this->alamat = null;
            $this->tlahir = null;
            $this->nohp = null;
        } else {
            $this->pasien_id = null; // reset pasien lama
        }
    }

    public function addLayanan()
    {
        if ($this->layanan_id) {
            $layanan = Layanan::find($this->layanan_id);
            $this->list[] = [
                'id' => $layanan->id,
                'nama' => $layanan->nama,
                'harga' => $layanan->harga,
                'deskripsi' => $layanan->deskripsi,
                'harga' => $layanan->harga
            ];
            $this->layanan_id = null;
        }
    }

    public function removeLayanan($index)
    {
        unset($this->list[$index]);
        $this->list = array_values($this->list);
    }

    public function simpan()
    {
        $this->validate([
            'list' => 'required|array|min:1',
            'waktu' => 'required|date',
        ]);

        if ($this->formTambahPasien) {
            $this->validate([
                'nama' => 'required|string',
                'alamat' => 'required|string',
                'tlahir' => 'required|date',
                'nohp' => 'required|string'
            ]);

            $pasien = Pasien::create([
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                'tlahir' => $this->tlahir,
                'nohp' => $this->nohp,
            ]);
        } else {
            $this->validate([
                'pasien_id' => 'required|exists:pasiens,id'
            ]);
            $pasien = Pasien::find($this->pasien_id);
        }

        DB::transaction(function () use ($pasien) {
            $transaksi = Transaksi::create([
                'pasien_id' => $pasien->id,
                'nama' => $pasien->nama,
                'alamat' => $pasien->alamat,
                'tlahir' => $pasien->tlahir,
                'nohp' => $pasien->nohp,
                'waktu' => Carbon::parse($this->waktu),
                'status' => 1,
            ]);

            foreach ($this->list as $item) {
                ListTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'layanan_id' => $item['id'],
                    'nama' => $item['nama'],
                    'deskripsi' => $item['deskripsi'],
                    'harga' => $item['harga'],
                ]);
            }
        });

        session()->flash('success', 'Transaksi berhasil ditambahkan');
        return redirect()->to('/transaksi');
    }

    public function render()
    {
        return view('livewire.create-transaksi', [
            'pasiens' => Pasien::all(),
            'layanans' => Layanan::all()
        ]);
    }
}
