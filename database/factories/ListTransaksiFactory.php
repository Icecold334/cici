<?php

namespace Database\Factories;

use App\Models\Layanan;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ListTransaksi>
 */
class ListTransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaksi_id' => Transaksi::factory(),
            'layanan_id' => Layanan::factory(),
            'harga' => 0,
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function ($listTransaksi) {
            // pastikan layanan sudah tersedia
            $layanan = $listTransaksi->layanan ?? Layanan::find($listTransaksi->layanan_id);
            $listTransaksi->harga = $layanan->harga ?? 0;
        })->afterCreating(function ($listTransaksi) {
            // ulangi untuk jaga-jaga kalau afterMaking terlewat
            $layanan = $listTransaksi->layanan ?? Layanan::find($listTransaksi->layanan_id);
            $listTransaksi->harga = $layanan->harga ?? 0;
            $listTransaksi->save();
        });
    }
}
