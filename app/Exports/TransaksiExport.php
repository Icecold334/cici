<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithStyles,
    WithEvents,
    WithTitle,
    ShouldAutoSize
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class TransaksiExport implements FromCollection, WithStyles, WithEvents, WithTitle, ShouldAutoSize
{
    protected $data;
    protected $info;

    public function __construct(Collection $data, array $info = [])
    {
        $this->data = $data;
        $this->info = $info;
    }

    public function collection()
    {
        function format_rupiah($angka)
        {
            return 'Rp ' . number_format($angka, 0, ',', '.');
        }
        // Header atas + info filter
        $rows = collect([
            [env('APP_NAME')],
            ['Tanggal Export:', now()->translatedFormat('l, d F Y')],
            ['Filter Status:', $this->info['status'] ?? 'Semua Status'],
            ['Filter Tanggal:', $this->info['tanggal'] ?? 'Semua Tanggal'],
            ['Total Transaksi:', $this->data->count()],
            ['Total Nominal:', format_rupiah(
                $this->data->sum(fn($item) => $item->listTransaksis->sum('harga'))
            )],
            ['Tanggal', 'Nama Pasien', 'Status', 'Nomor HP', 'Alamat', 'Total'],
        ]);

        // Baris data mulai dari A11
        $dataRows = $this->data->map(function ($item) {
            $total = $item->listTransaksis->sum('harga');

            return [
                $item->waktu->translatedFormat('l, d F Y H:i'),
                $item->pasien->nama ?? $item->nama,
                $item->status_nama,
                $item->nohp,
                $item->alamat,
                format_rupiah($total),
            ];
        });

        return $rows->concat($dataRows)->values();
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A1' => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => 'center'],
            ],
            'A2:A6' => ['font' => ['bold' => true]],
            'B2:B6' => ['alignment' => ['horizontal' => 'right'],],
            7 => [ // header kolom tabel
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge untuk judul & subjudul
                $event->sheet->mergeCells('A1:F1');
                // $event->sheet->mergeCells('A2:F2');
                $event->sheet->freezePane('A8');
                $event->sheet->setAutoFilter('A7:F7');

                // Warnai baris heading tabel
                $event->sheet->getStyle('A7:F7')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'f9a8d4'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '888888'],
                        ],
                    ],
                ]);
                $event->sheet->getStyle('F8:F' . (7 + $this->data->count()))
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            }
        ];
    }

    public function title(): string
    {
        return 'Laporan Transaksi';
    }
}
