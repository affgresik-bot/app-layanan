<?php

namespace Database\Seeders;

use App\Enums\PublishStatus;
use App\Models\DownloadableForm;
use App\Models\Faq;
use App\Models\InformationPage;
use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class InformationPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@dinsos.blitarkab.go.id')->first();
        $dtsenType = ServiceType::where('code', 'DTSEN')->first();
        $pbiType = ServiceType::where('code', 'PBI')->first();

        // 1. Informasi SK DTSEN
        $dtsenPage = InformationPage::updateOrCreate(
            ['slug' => 'surat-keterangan-dtsen'],
            [
                'title' => 'Panduan & Prosedur Penerbitan Surat Keterangan DTSEN',
                'category' => 'program',
                'service_type_id' => $dtsenType?->id,
                'description' => 'Surat Keterangan DTSEN diterbitkan bagi warga Kabupaten Blitar yang terdaftar dalam Data Tunggal Sosial Ekonomi Nasional (DTSEN) untuk memenuhi persyaratan SPMB jalur afirmasi, PIP, KIP-K, atau keringanan biaya kesehatan.',
                'requirements' => "1. Foto/Scan KTP Pemohon (asli)\n2. Foto/Scan Kartu Keluarga (KK) terbaru\n3. Surat Pengantar RT/RW atau Desa (opsional bila diperlukan verifikasi tambahan)",
                'procedure' => "1. Masyarakat mengajukan permohonan melalui portal SAPA SOSIAL atau melalui Operator Desa/Kecamatan.\n2. Petugas Dinsos memvalidasi kelengkapan berkas.\n3. Petugas mengecek data pemohon dan orang yang bersangkutan pada aplikasi SIKS-NG Pusat.\n4. Draf surat dibuat otomatis bila memenuhi kriteria desil tujuan penggunaan.\n5. Surat diparaf Kabid dan disetujui Kepala Dinas Sosial.\n6. Pemohon menerima PDF ber-QR code dan dapat mencetaknya langsung.",
                'service_hours' => 'Senin - Jumat: 08.00 - 15.00 WIB',
                'location' => 'Kantor Dinas Sosial Kabupaten Blitar, Jl. Raya Kanigoro',
                'contact' => 'Telp: (0342) 801123 / WhatsApp: 081234567890',
                'publish_status' => PublishStatus::Published,
                'published_at' => Carbon::now(),
                'manager_id' => $admin?->id,
            ]
        );

        DownloadableForm::updateOrCreate(
            ['information_page_id' => $dtsenPage->id, 'name' => 'Formulir Verifikasi Lapangan DTSEN.pdf'],
            [
                'file_path' => 'forms/formulir-verifikasi-dtsen-v1.pdf',
                'version' => '1.0',
                'is_current' => true,
            ]
        );

        Faq::updateOrCreate(
            ['information_page_id' => $dtsenPage->id, 'question' => 'Berapa lama proses penerbitan Surat Keterangan DTSEN?'],
            [
                'answer' => 'Proses penerbitan memerlukan waktu maksimal 2 (dua) hari kerja sejak berkas dinyatakan lengkap dan terverifikasi di SIKS-NG.',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Faq::updateOrCreate(
            ['information_page_id' => $dtsenPage->id, 'question' => 'Bagaimana jika nama saya tidak ditemukan di SIKS-NG atau di luar desil batas ketentuan?'],
            [
                'answer' => 'Pengajuan akan ditolak dengan penjelasan tertulis. Pemohon disarankan berkoordinasi dengan pihak desa/kelurahan setempat melalui Musyawarah Desa (Musdes) untuk pengusulan pemutakhiran data DTSEN periode berikutnya.',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        // 2. Informasi Reaktivasi KIS / PBI-JK
        $pbiPage = InformationPage::updateOrCreate(
            ['slug' => 'reaktivasi-kis-pbi-jk'],
            [
                'title' => 'Panduan Pengaktifan Kembali Kepesertaan KIS / PBI-JK Nonaktif',
                'category' => 'program',
                'service_type_id' => $pbiType?->id,
                'description' => 'Fasilitasi penerbitan surat rekomendasi dari Dinas Sosial Kabupaten Blitar ke Kementerian Sosial RI untuk reaktivasi kartu BPJS Kesehatan PBI-JK yang terblokir atau dinonaktifkan.',
                'requirements' => "1. KTP dan Kartu Keluarga (KK)\n2. Kartu BPJS / KIS yang nonaktif\n3. Surat Keterangan Rawat Inap / Surat Keterangan Medis dari Rumah Sakit / Puskesmas bagi kondisi darurat medis atau penyakit kronis",
                'procedure' => "1. Pemohon atau operator menginput pengajuan dengan melampirkan berkas dan surat keterangan faskes.\n2. Verifikasi status kelayakan di SIKS-NG.\n3. Kepala Bidang dan Kepala Dinas menerbitkan Surat Rekomendasi Reaktivasi.\n4. Petugas Linjamsos menginput usulan ke SIKS-NG Kemensos RI.\n5. Petugas memantau persetujuan Kemensos dan pengaktifan di BPJS Kesehatan hingga kartu aktif kembali.",
                'service_hours' => 'Senin - Jumat: 08.00 - 15.00 WIB (Kondisi Darurat dilayani prioritas)',
                'location' => 'Kantor Dinas Sosial Kabupaten Blitar',
                'contact' => 'WhatsApp Layanan PBI: 081234567891',
                'publish_status' => PublishStatus::Published,
                'published_at' => Carbon::now(),
                'manager_id' => $admin?->id,
            ]
        );

        Faq::updateOrCreate(
            ['information_page_id' => $pbiPage->id, 'question' => 'Siapa saja yang berhak mengajukan reaktivasi PBI-JK?'],
            [
                'answer' => 'Warga yang sebelumnya merupakan peserta PBI-JK yang dinonaktifkan dalam batas waktu tertentu, terutama yang membutuhkan perawatan penyakit kronis, katastropik, kondisi gawat darurat medis, atau bayi baru lahir dari ibu peserta PBI-JK.',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        // 3. Informasi FAQ Umum / Non-Layanan Khusus
        Faq::updateOrCreate(
            ['question' => 'Bagaimana cara mengecek status pengajuan atau pengaduan saya?'],
            [
                'information_page_id' => null,
                'answer' => 'Anda dapat memasukkan Nomor Tiket (contoh: DTSEN-202610-00001 atau ADU-202610-00001) beserta 4 digit terakhir NIK Anda pada menu "Cek Status" di portal utama SAPA SOSIAL.',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );
    }
}
