<?php

namespace Database\Seeders;

use App\Models\ServiceRequirement;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'code' => 'DTSEN',
                'name' => 'Surat Keterangan DTSEN',
                'category' => 'Perlindungan Sosial',
                'description' => 'Penerbitan surat keterangan yang menerangkan status kepesertaan dalam Data Tunggal Sosial Ekonomi Nasional (DTSEN) beserta peringkat desil untuk keperluan SPMB afirmasi, KIP, PIP, bansos, atau keringanan kesehatan.',
                'handler' => 'dtsen',
                'needs_assessment' => false,
                'sla_days' => 2,
                'is_active' => true,
                'requirements' => [
                    [
                        'name' => 'KTP Pemohon / Orang Tua',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Kartu Keluarga (KK)',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Surat Pengantar RT/RW atau Desa',
                        'is_mandatory' => false,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 3,
                    ],
                ],
            ],
            [
                'code' => 'PBI',
                'name' => 'Reaktivasi KIS / PBI-JK',
                'category' => 'Jaminan Sosial Kesehatan',
                'description' => 'Fasilitasi penerbitan surat rekomendasi pengaktifan kembali status kepesertaan JKN-KIS Penerima Bantuan Iuran Jaminan Kesehatan (PBI-JK) yang nonaktif ke Kementerian Sosial RI.',
                'handler' => 'pbi',
                'needs_assessment' => false,
                'sla_days' => 3,
                'is_active' => true,
                'requirements' => [
                    [
                        'name' => 'KTP Peserta',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Kartu Keluarga (KK)',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Kartu KIS / BPJS Kesehatan',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Surat Keterangan Rawat Inap / Resume Medis Faskes',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 4,
                    ],
                ],
            ],
            [
                'code' => 'REHSOS',
                'name' => 'Permohonan Pelayanan Rehabilitasi Sosial',
                'category' => 'Rehabilitasi Sosial',
                'description' => 'Permohonan pelayanan dan rehabilitasi sosial untuk Pemerlu Pelayanan Kesejahteraan Sosial (lansia terlantar, anak, disabilitas, ODGJ) baik pelayanan langsung maupun rujukan ke panti/lembaga.',
                'handler' => 'generic',
                'needs_assessment' => true,
                'sla_days' => 7,
                'is_active' => true,
                'requirements' => [
                    [
                        'name' => 'KTP / Identitas Klien / Foto Klien',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Kartu Keluarga (KK)',
                        'is_mandatory' => false,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Surat Keterangan / Rekomendasi Desa',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 3,
                    ],
                ],
            ],
            [
                'code' => 'BANSOS_REK',
                'name' => 'Rekomendasi Bantuan Sosial / Bantuan UEP',
                'category' => 'Pemberdayaan Sosial',
                'description' => 'Penerbitan surat rekomendasi untuk usulan bantuan sosial, bantuan Usaha Ekonomi Produktif (UEP), atau bantuan sosial terencana lainnya bagi warga kurang mampu.',
                'handler' => 'generic',
                'needs_assessment' => true,
                'sla_days' => 5,
                'is_active' => true,
                'requirements' => [
                    [
                        'name' => 'KTP Pemohon',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Kartu Keluarga (KK)',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Surat Keterangan Tidak Mampu (SKTM) dari Desa/Kelurahan',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Foto Tempat Tinggal / Usaha',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 4,
                    ],
                ],
            ],
        ];

        foreach ($types as $typeData) {
            $requirements = $typeData['requirements'];
            unset($typeData['requirements']);

            $serviceType = ServiceType::updateOrCreate(
                ['code' => $typeData['code']],
                $typeData
            );

            foreach ($requirements as $reqData) {
                ServiceRequirement::updateOrCreate(
                    [
                        'service_type_id' => $serviceType->id,
                        'name' => $reqData['name'],
                    ],
                    array_merge($reqData, ['service_type_id' => $serviceType->id])
                );
            }
        }
    }
}
