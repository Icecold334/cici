<?php

use App\Models\Layanan;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () {
    $layanans = Layanan::orderBy('nama')->get();

    return view('welcome', compact('layanans'));
})->name('home');
Route::get('/booking', function () {
    $layanans = Layanan::orderBy('nama')->get();

    return view('booking', compact('layanans'));
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::get('pasien', [PasienController::class, 'index'])->name('pasien.index');
    Route::get('pasien/show/{id}', [PasienController::class, 'show'])->name('pasien.show');
    Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('transaksi/add', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::get('transaksi/show/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');

    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
