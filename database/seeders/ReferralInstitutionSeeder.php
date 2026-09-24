<?php

namespace Database\Seeders;

use App\Models\ReferralInstitution;
use Illuminate\Database\Seeder;

class ReferralInstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institutions = [
            [
                'name' => 'UPT Pelayanan Sosial Tresna Werdha (PSTW) Blitar',
                'type' => 'panti',
                'address' => 'Jl. Banteng Blorok, Kec. Garum, Kabupaten Blitar',
                'contact' => '(0342) 801234',
                'is_active' => true,
            ],
            [
                'name' => 'RSUD Ngudi Waluyo Wlingi',
                'type' => 'RS',
                'address' => 'Jl. Dr. Soetomo No. 2, Kec. Wlingi, Kabupaten Blitar',
                'contact' => '(0342) 691006',
                'is_active' => true,
            ],
            [
                'name' => 'RSUD Srengat Kabupaten Blitar',
                'type' => 'RS',
                'address' => 'Jl. Raya Dandong No. 1, Kec. Srengat, Kabupaten Blitar',
                'contact' => '(0342) 555666',
                'is_active' => true,
            ],
            [
                'name' => 'RSJ Dr. Radjiman Wediodiningrat Lawang',
                'type' => 'RS',
                'address' => 'Jl. Jend. A. Yani, Lawang, Malang',
                'contact' => '(0341) 426015',
                'is_active' => true,
            ],
            [
                'name' => 'Sentra Terpadu Balai Rehabilitasi Sosial Anak (BRSAMPK)',
                'type' => 'balai',
                'address' => 'Surabaya, Jawa Timur',
                'contact' => '(031) 8290001',
                'is_active' => true,
            ],
            [
                'name' => 'Lembaga Kesejahteraan Sosial (LKS) Disabilitas Harapan Mulia',
                'type' => 'LKS',
                'address' => 'Kec. Kanigoro, Kabupaten Blitar',
                'contact' => '081298765432',
                'is_active' => true,
            ],
        ];

        foreach ($institutions as $inst) {
            ReferralInstitution::updateOrCreate(
                ['name' => $inst['name']],
                $inst
            );
        }
    }
}
