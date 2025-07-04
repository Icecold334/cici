<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    /** @use HasFactory<\Database\Factories\PasienFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'tlahir' => 'datetime',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
