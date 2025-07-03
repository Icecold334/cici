<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Transaksi;
use Livewire\WithPagination;
use App\Exports\TransaksiExport;
use Livewire\WithoutUrlPagination;
use Maatwebsite\Excel\Facades\Excel;

class DataTransaksi extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $paginate = 5;
    public $filterStatus = '';
    public $filterTanggal = '';

    public $kode_transaksi, $kode_booking, $status, $nama, $alamat, $tlahir, $nohp, $waktu;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string',
        'tlahir' => 'required|date',
        'nohp' => 'required|string|max:20',
        'waktu' => 'required|date',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportExcel()
    {
        $query = Transaksi::with('pasien');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus !== '') {
            $query->where('status', (int)$this->filterStatus);
        }

        if ($this->filterTanggal !== '') {
            $query->whereDate('waktu', $this->filterTanggal);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $info = [
            'status' => $this->filterStatus !== '' ? $this->statusToString($this->filterStatus) : 'Semua Status',
            'tanggal' => $this->filterTanggal
                ? Carbon::parse($this->filterTanggal)->translatedFormat('l, d F Y')
                : 'Semua Tanggal',
        ];

        $filename = 'Laporan_' . now()->day . '-' . now()->month . '-' . now()->year . '_' . now()->format('His') . '.xlsx';

        return Excel::download(new TransaksiExport($data, $info), $filename);
    }



    protected function statusToString($val)
    {
        return match ((int)$val) {
            0 => 'Booking Masuk',
            1 => 'Dikonfirmasi',
            2 => 'Diproses',
            3 => 'Selesai',
            4 => 'Dibatalkan',
            default => 'Unknown'
        };
    }




    public function addTransaksi()
    {
        return redirect()->to('transaksi/add');
    }
    public function showTransaksi($id)
    {
        return redirect()->to('transaksi/show/' . $id);
    }

    public function lanjutStatus($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status < 3) {
            $transaksi->status = $transaksi->status + 1;
            $transaksi->save();

            session()->flash('success', 'Status transaksi diperbarui menjadi: ' . $transaksi->status_nama);
        }
    }

    public function batalkanTransaksi($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if (in_array($transaksi->status, [0, 1])) {
            $transaksi->status = 4; // Dibatalkan
            $transaksi->save();

            session()->flash('success', 'Transaksi telah dibatalkan.');
        }
    }

    public function render()
    {
        $query = Transaksi::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%');
                // ->orWhere('kode_transaksi', 'like', '%' . $this->search . '%')
                // ->orWhere('kode_booking', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus !== '') {
            $query->where('status', (int)$this->filterStatus);
        }

        if ($this->filterTanggal !== '') {
            $query->whereDate('waktu', $this->filterTanggal);
        }

        $transaksis = $query->orderBy('created_at', 'desc')
            ->paginate($this->paginate);

        return view('livewire.data-transaksi', compact('transaksis'));
    }
}
