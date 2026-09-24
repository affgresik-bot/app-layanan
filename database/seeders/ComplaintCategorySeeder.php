<?php

namespace Database\Seeders;

use App\Models\ComplaintCategory;
use Illuminate\Database\Seeder;

class ComplaintCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Lansia Terlantar / Tidak Terawat',
            'ODGJ Terlantar / Mengganggu Ketertiban',
            'Anak Terlantar / Kekerasan pada Anak',
            'Dugaan Bantuan Sosial Tidak Tepat Sasaran',
            'Pelayanan Petugas / Operator Sosial',
            'Penyandang Disabilitas Membutuhkan Bantuan Darurat',
            'Korban Bencana Sosial / Kebakaran',
            'Permasalahan Kesejahteraan Sosial Lainnya',
        ];

        foreach ($categories as $cat) {
            ComplaintCategory::firstOrCreate(
                ['name' => $cat],
                ['is_active' => true]
            );
        }
    }
}
