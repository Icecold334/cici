<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\ListTransaksi;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DataDashboard extends Component
{
    public $todayTransactionCount;
    public $todayRevenue;
    public $monthTransactionCount;
    public $monthRevenue;
    public $bookingActiveCount;
    public $completedTransactionCount;
    public $labels = [];
    public $data = [];
    public array $transaksiPerStatus = [];
    public $pieFavoritLabels = [];
    public $pieFavoritData = [];
    public function mount()
    {
        // Transaksi selesai hari ini
        $this->todayTransactionCount = Transaksi::whereDate('waktu', today())
            ->where('status', 3) // hanya yang selesai
            ->count();

        $this->todayRevenue = ListTransaksi::whereHas('transaksi', function ($q) {
            $q->whereDate('waktu', today())->where('status', 3);
        })->sum('harga');

        // Transaksi selesai bulan ini
        $this->monthTransactionCount = Transaksi::whereMonth('waktu', now()->month)
            ->where('status', 3)
            ->count();

        $this->monthRevenue = ListTransaksi::whereHas('transaksi', function ($q) {
            $q->whereMonth('waktu', now()->month)->where('status', 3);
        })->sum('harga');

        // Booking aktif (status = 0)
        $this->bookingActiveCount = Transaksi::where('status', 0)->count();

        // Transaksi selesai
        $this->completedTransactionCount = Transaksi::where('status', 3)->count();


        $days = collect();

        // Ambil 7 hari terakhir dari hari ini mundur
        for ($i = 14; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $label = $date->translatedFormat('l');
            $total = Transaksi::where('status', 3)
                ->whereDate('waktu', $date)
                ->with('listTransaksis')
                ->get()
                ->sum(fn($trx) => $trx->listTransaksis->sum('harga'));

            $days->push([
                'label' => $label,
                'total' => $total,
            ]);
        }

        $this->labels = $days->pluck('label')->toArray();
        $this->data = $days->pluck('total')->toArray();

        $statusList = [
            0 => 'Booking',
            1 => 'Dikonfirmasi',
            2 => 'Diproses',
            3 => 'Selesai',
            4 => 'Dibatalkan',
        ];

        $this->transaksiPerStatus = collect($statusList)->mapWithKeys(function ($label, $status) {
            return [$label => Transaksi::where('status', $status)->count()];
        })->toArray();

        $list = ListTransaksi::whereHas('transaksi', fn($q) => $q->where('status', '!=', 4))
            ->whereHas('layanan')
            ->with('layanan')
            ->get()
            ->groupBy('layanan.nama')
            ->map(fn($group) => $group->count())
            ->sortDesc()
            ->take(5);

        $this->pieFavoritLabels = $list->keys();
        $this->pieFavoritData = $list->values();
    }


    public function render()
    {
        $transaksiTerbaru = Transaksi::with('pasien')
            ->where('status', 3)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $bookingHariIni = Transaksi::with('pasien')
            ->whereDate('waktu', now())
            ->where('status', 0)
            ->orderBy('waktu')
            ->limit(6)
            ->get();

        $topPasien = Transaksi::select('pasien_id', DB::raw('count(*) as total'))
            ->where('status', 3)
            ->whereNotNull('pasien_id')
            ->groupBy('pasien_id')
            ->orderByDesc('total')
            ->with('pasien')
            ->limit(5)
            ->get();

        return view('livewire.data-dashboard', [
            // ...data sebelumnya...
            'transaksiTerbaru' => $transaksiTerbaru,
            'bookingHariIni' => $bookingHariIni,
            'topPasien' => $topPasien,
        ]);
    }
}
