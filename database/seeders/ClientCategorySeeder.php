<?php

namespace Database\Seeders;

use App\Models\ClientCategory;
use Illuminate\Database\Seeder;

class ClientCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Lanjut Usia Terlantar',
            'Penyandang Disabilitas Terlantar',
            'Orang Dengan Gangguan Jiwa (ODGJ) Terlantar',
            'Anak Terlantar / Memerlukan Perlindungan Khusus',
            'Korban Tindak Kekerasan (KTK) dan KDRT',
            'Gelandangan dan Pengemis (Gepeng)',
            'Pekerja Migran Bermasalah Sosial (PMBS)',
            'Korban Penyalahgunaan Napza',
        ];

        foreach ($categories as $categoryName) {
            ClientCategory::firstOrCreate(['name' => $categoryName]);
        }
    }
}
