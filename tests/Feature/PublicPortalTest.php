<?php

namespace Tests\Feature;

use App\Livewire\Beranda;
use App\Livewire\CekStatus;
use App\Livewire\InformasiLayanan;
use App\Livewire\PengaduanSosial;
use App\Livewire\PengajuanDtsen;
use App\Livewire\PengajuanPbi;
use App\Livewire\PilihJenisLayanan;
use App\Livewire\VerifikasiSurat;
use Livewire\Livewire;
use Tests\TestCase;

class PublicPortalTest extends TestCase
{
    public function test_all_public_pages_are_accessible(): void
    {
        $this->get(route('home'))->assertOk();
        $this->get(route('informasi.index'))->assertOk();
        $this->get(route('layanan.index'))->assertOk();
        $this->get(route('layanan.dtsen'))->assertOk();
        $this->get(route('layanan.pbi'))->assertOk();
        $this->get(route('cek-status'))->assertOk();
        $this->get(route('pengaduan'))->assertOk();
        $this->get(route('verifikasi'))->assertOk();
        $this->get(route('login'))->assertOk();
    }

    public function test_livewire_components_render_successfully(): void
    {
        Livewire::test(Beranda::class)->assertOk();
        Livewire::test(InformasiLayanan::class)->assertOk();
        Livewire::test(PilihJenisLayanan::class)->assertOk();
        Livewire::test(PengajuanDtsen::class)->assertOk();
        Livewire::test(PengajuanPbi::class)->assertOk();
        Livewire::test(CekStatus::class)->assertOk();
        Livewire::test(PengaduanSosial::class)->assertOk();
        Livewire::test(VerifikasiSurat::class)->assertOk();
    }

    public function test_verification_page_detects_invalid_code(): void
    {
        Livewire::test(VerifikasiSurat::class, ['code' => 'INVALID-CODE-9999'])
            ->assertSet('checkStatus', 'not_found');
    }
}
