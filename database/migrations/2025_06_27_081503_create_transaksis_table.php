<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->nullable();
            $table->string('kode_booking')->nullable();
            $table->integer('status')->default(0);
            $table->string('nama');
            $table->string('alamat');
            $table->timestamp('tlahir');
            $table->string('nohp');
            $table->timestamp('waktu');
            $table->foreignId('pasien_id')->nullable()->constrained('pasiens');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
