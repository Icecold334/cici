<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pasien;
use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\ListTransaksi;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Layanan::factory(15)->create();
        Pasien::factory(50)->create();
        Transaksi::factory(100)->create();


        User::factory()->create([
            'name' => 'Beauty Clinic',
            'email' => 'bucici@email.com',
        ]);
    }
}
