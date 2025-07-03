<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithStyles,
    WithEvents,
    WithTitle,
    ShouldAutoSize
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class TransaksiExport implements FromCollection, WithHeadings, WithStyles, WithEvents, WithTitle, ShouldAutoSize
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
        // Susun manual semua baris Excel
        $rows = collect([
            [env('APP_NAME')],                                 // A1
            ['Laporan Transaksi'],                             // A2
            ['Tanggal Export:', now()->format('Y-m-d H:i')],   // A3
            ['Filter Nama:', $this->info['search'] ?? '-'],    // A4
            ['Filter Status:', $this->info['status'] ?? '-'],  // A5
            ['Filter Tanggal:', $this->info['tanggal'] ?? '-'], // A6
            ['Total Transaksi:', $this->data->count()],        // A7
            ['Total Nominal:', format_rupiah(
                $this->data->sum(fn($item) => $item->listTransaksis->sum('harga'))
            )],
            // A8
            [], // Kosong (baris pemisah)
            $this->headings(), // Baris Heading ke-10
        ]);

        // Isi data baris transaksi
        $dataRows = $this->data->map(function ($item) {
            $total = $item->listTransaksis->sum('harga');

            return [
                $item->waktu->format('Y-m-d H:i'),
                $item->pasien->nama ?? $item->nama,
                $item->status_nama,
                $item->nohp,
                $item->alamat,
                format_rupiah($total),
            ];
        });

        return $rows->concat($dataRows)->values();
    }

    public function headings(): array
    {
        return ['Tanggal', 'Nama Pasien', 'Status', 'Nomor HP', 'Alamat', 'Total'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A1' => ['font' => ['bold' => true, 'size' => 16]],
            'A2' => ['font' => ['bold' => true, 'size' => 14]],
            10 => [ // baris heading
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge untuk judul dan subjudul
                $event->sheet->mergeCells('A1:F1');
                $event->sheet->mergeCells('A2:F2');

                // Warnai header tabel
                $headerRange = 'A10:F10';
                $event->sheet->getStyle($headerRange)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'D1E3F8'], // biru muda
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '888888'],
                        ],
                    ],
                ]);
            }
        ];
    }

    public function title(): string
    {
        return 'Laporan Transaksi';
    }
}
