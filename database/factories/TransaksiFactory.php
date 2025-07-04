<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Layanan;
use App\Models\ListTransaksi;
use App\Models\Pasien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->numberBetween(0, 4);
        return [
            'kode_transaksi' => $status == 3 ? strtoupper(fake()->bothify('TRX-???-###-?##')) : '',
            'kode_booking' => strtoupper(fake()->bothify('BC-???-###-?##')),
            'nama' => fake()->name,
            'alamat' => fake()->address,
            'tlahir' => fake()->dateTimeBetween('-60 years', '-18 years'),
            'nohp' => fake()->phoneNumber,
            'pasien_id' => $status == 0 ? null : Pasien::all()->random()->id,
            'status' => $status,
            'waktu' => \Carbon\Carbon::now()
                ->subDays(fake()->numberBetween(0, 60))
                ->setTime(fake()->numberBetween(7, 18), fake()->numberBetween(0, 59)),

        ];
    }
    public function configure()
    {
        return $this->afterCreating(function ($transaksi) {
            // Ambil semua layanan dari database
            $layanans = Layanan::inRandomOrder()->take(fake()->numberBetween(1, 4))->get(); // ambil 3 layanan acak, tanpa duplikat

            foreach ($layanans as $layanan) {
                ListTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'layanan_id' => $layanan->id,
                    'nama' => $layanan->nama,
                    'deskripsi' => $layanan->deskripsi,
                    'harga' => $layanan->harga,
                ]);
            }
        });
    }
}
