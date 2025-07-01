<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaksi extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'tlahir' => 'datetime',
        'waktu' => 'datetime',
    ];

    protected function statusNama(): Attribute
    {
        return Attribute::get(function () {
            return match ($this->status) {
                0 => 'Booking Masuk',
                1 => 'Dikonfirmasi',
                2 => 'Diproses',
                3 => 'Selesai',
                4 => 'Dibatalkan',
                default => 'Tidak Diketahui',
            };
        });
    }
    protected function statusWarna(): Attribute
    {
        return Attribute::get(function () {
            return match ($this->status) {
                0 => 'bg-gray-500',
                1 => 'bg-blue-600',
                2 => 'bg-yellow-500',
                3 => 'bg-green-600',
                4 => 'bg-red-600',
                default => 'bg-gray-300',
            };
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function listTransaksis()
    {
        return $this->hasMany(\App\Models\ListTransaksi::class);
    }
}
