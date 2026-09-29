<?php

use App\Livewire\Auth\MasukDaftar;
use App\Livewire\Beranda;
use App\Livewire\CekStatus;
use App\Livewire\InformasiLayanan;
use App\Livewire\PengaduanSosial;
use App\Livewire\PengajuanDtsen;
use App\Livewire\PengajuanPbi;
use App\Livewire\PilihJenisLayanan;
use App\Livewire\RiwayatPengajuan;
use App\Livewire\VerifikasiSurat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public Portal Routes
Route::get('/', Beranda::class)->name('home');
Route::get('/informasi-layanan/{slug?}', InformasiLayanan::class)->name('informasi.index');
Route::get('/informasi/{slug}', InformasiLayanan::class)->name('informasi.show');
Route::get('/ajukan-layanan', PilihJenisLayanan::class)->name('layanan.index');
Route::get('/ajukan-layanan/dtsen', PengajuanDtsen::class)->name('layanan.dtsen');
Route::get('/ajukan-layanan/pbi', PengajuanPbi::class)->name('layanan.pbi');
Route::get('/cek-status/{ticket?}', CekStatus::class)->name('cek-status');
Route::get('/pengaduan', PengaduanSosial::class)->name('pengaduan');
Route::get('/verifikasi/{code?}', VerifikasiSurat::class)->name('verifikasi');

// Citizen Authentication & Account
Route::get('/masuk', MasukDaftar::class)->name('login')->middleware('guest');
Route::get('/riwayat-pengajuan', RiwayatPengajuan::class)->name('riwayat.pengajuan')->middleware('auth');

Route::post('/keluar', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');
})->name('logout')->middleware('auth');
