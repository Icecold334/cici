<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    /** @use HasFactory<\Database\Factories\LayananFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    public function getRupiahAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
