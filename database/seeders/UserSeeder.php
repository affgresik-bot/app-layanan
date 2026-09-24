<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\User;
use App\Models\Village;
use App\Models\WorkUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $linjamsos = WorkUnit::where('name', 'like', '%Linjamsos%')->first();
        $rehsos = WorkUnit::where('name', 'like', '%Rehabilitasi%')->first();
        $sekretariat = WorkUnit::where('name', 'like', '%Sekretariat%')->first();

        $kanigoroDistrict = District::where('name', 'Kanigoro')->first();
        $kanigoroVillage = Village::where('name', 'Kanigoro')->first();

        $defaultPassword = Hash::make('password');

        $users = [
            [
                'name' => 'Administrator Sistem',
                'email' => 'admin@dinsos.blitarkab.go.id',
                'phone' => '081234567890',
                'nik' => '3505070101850001',
                'password' => $defaultPassword,
                'work_unit_id' => $sekretariat?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Kepala Dinas Sosial',
                'email' => 'kadis@dinsos.blitarkab.go.id',
                'phone' => '081234567891',
                'nik' => '3505070202750002',
                'password' => $defaultPassword,
                'work_unit_id' => $sekretariat?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Kepala Bidang Linjamsos',
                'email' => 'kabid.linjamsos@dinsos.blitarkab.go.id',
                'phone' => '081234567892',
                'nik' => '3505070303800003',
                'password' => $defaultPassword,
                'work_unit_id' => $linjamsos?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Petugas Pelayanan DTSEN & PBI',
                'email' => 'petugas.layanan@dinsos.blitarkab.go.id',
                'phone' => '081234567893',
                'nik' => '3505070404900004',
                'password' => $defaultPassword,
                'work_unit_id' => $linjamsos?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Petugas Rehabilitasi Sosial',
                'email' => 'petugas.rehsos@dinsos.blitarkab.go.id',
                'phone' => '081234567894',
                'nik' => '3505070505920005',
                'password' => $defaultPassword,
                'work_unit_id' => $rehsos?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Operator Kecamatan Kanigoro',
                'email' => 'operator.kanigoro@blitarkab.go.id',
                'phone' => '081234567895',
                'nik' => '3505070606940006',
                'password' => $defaultPassword,
                'district_id' => $kanigoroDistrict?->id,
                'village_id' => $kanigoroVillage?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Masyarakat Pemohon',
                'email' => 'warga@gmail.com',
                'phone' => '085700001122',
                'nik' => '3505071208960007',
                'password' => $defaultPassword,
                'district_id' => $kanigoroDistrict?->id,
                'village_id' => $kanigoroVillage?->id,
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
