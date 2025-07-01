<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTransaksi extends Model
{
    /** @use HasFactory<\Database\Factories\ListTransaksiFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function layanan()
    {
        return $this->belongsTo(\App\Models\Layanan::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(\App\Models\Transaksi::class);
    }
}
