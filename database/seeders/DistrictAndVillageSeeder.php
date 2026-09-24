<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Village;
use Illuminate\Database\Seeder;

class DistrictAndVillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [
                'code' => '35.05.07',
                'name' => 'Kanigoro',
                'villages' => [
                    ['code' => '35.05.07.1001', 'name' => 'Kanigoro'],
                    ['code' => '35.05.07.1002', 'name' => 'Satreyan'],
                    ['code' => '35.05.07.2003', 'name' => 'Tlogo'],
                    ['code' => '35.05.07.2004', 'name' => 'Gaprang'],
                    ['code' => '35.05.07.2005', 'name' => 'Papungan'],
                    ['code' => '35.05.07.2006', 'name' => 'Sawentar'],
                    ['code' => '35.05.07.2007', 'name' => 'Minggirsari'],
                    ['code' => '35.05.07.2008', 'name' => 'Kuningan'],
                ],
            ],
            [
                'code' => '35.05.05',
                'name' => 'Garum',
                'villages' => [
                    ['code' => '35.05.05.1001', 'name' => 'Garum'],
                    ['code' => '35.05.05.1002', 'name' => 'Bence'],
                    ['code' => '35.05.05.1003', 'name' => 'Tawangsari'],
                    ['code' => '35.05.05.2004', 'name' => 'Slorok'],
                    ['code' => '35.05.05.2005', 'name' => 'Pojok'],
                    ['code' => '35.05.05.2006', 'name' => 'Tingal'],
                ],
            ],
            [
                'code' => '35.05.09',
                'name' => 'Talun',
                'villages' => [
                    ['code' => '35.05.09.1001', 'name' => 'Talun'],
                    ['code' => '35.05.09.1002', 'name' => 'Kamulan'],
                    ['code' => '35.05.09.2003', 'name' => 'Pasirharjo'],
                    ['code' => '35.05.09.2004', 'name' => 'Kendalrejo'],
                    ['code' => '35.05.09.2005', 'name' => 'Jeblog'],
                ],
            ],
            [
                'code' => '35.05.13',
                'name' => 'Wlingi',
                'villages' => [
                    ['code' => '35.05.13.1001', 'name' => 'Beru'],
                    ['code' => '35.05.13.1002', 'name' => 'Babadan'],
                    ['code' => '35.05.13.1003', 'name' => 'Klemunan'],
                    ['code' => '35.05.13.1004', 'name' => 'Tangkil'],
                    ['code' => '35.05.13.1005', 'name' => 'Wlingi'],
                    ['code' => '35.05.13.2006', 'name' => 'Tegalasri'],
                ],
            ],
            [
                'code' => '35.05.06',
                'name' => 'Sutojayan',
                'villages' => [
                    ['code' => '35.05.06.1001', 'name' => 'Kalipang'],
                    ['code' => '35.05.06.1002', 'name' => 'Sukorejo'],
                    ['code' => '35.05.06.1003', 'name' => 'Kembangarum'],
                    ['code' => '35.05.06.1004', 'name' => 'Jingglong'],
                    ['code' => '35.05.06.2005', 'name' => 'Pandanyaran'],
                ],
            ],
            [
                'code' => '35.05.15',
                'name' => 'Srengat',
                'villages' => [
                    ['code' => '35.05.15.1001', 'name' => 'Srengat'],
                    ['code' => '35.05.15.1002', 'name' => 'Dandong'],
                    ['code' => '35.05.15.1003', 'name' => 'Kauman'],
                    ['code' => '35.05.15.1004', 'name' => 'Togogan'],
                    ['code' => '35.05.15.2005', 'name' => 'Kandangan'],
                ],
            ],
            [
                'code' => '35.05.16',
                'name' => 'Ponggok',
                'villages' => [
                    ['code' => '35.05.16.2001', 'name' => 'Ponggok'],
                    ['code' => '35.05.16.2002', 'name' => 'Bacem'],
                    ['code' => '35.05.16.2003', 'name' => 'Gembongan'],
                ],
            ],
            [
                'code' => '35.05.17',
                'name' => 'Sanankulon',
                'villages' => [
                    ['code' => '35.05.17.2001', 'name' => 'Sanankulon'],
                    ['code' => '35.05.17.2002', 'name' => 'Bendowulung'],
                    ['code' => '35.05.17.2003', 'name' => 'Kalipucung'],
                ],
            ],
            [
                'code' => '35.05.08',
                'name' => 'Kademangan',
                'villages' => [
                    ['code' => '35.05.08.1001', 'name' => 'Kademangan'],
                    ['code' => '35.05.08.2002', 'name' => 'Plosorejo'],
                    ['code' => '35.05.08.2003', 'name' => 'Rejotangan'],
                ],
            ],
            [
                'code' => '35.05.14',
                'name' => 'Nglegok',
                'villages' => [
                    ['code' => '35.05.14.1001', 'name' => 'Nglegok'],
                    ['code' => '35.05.14.2002', 'name' => 'Modangan'],
                    ['code' => '35.05.14.2003', 'name' => 'Penataran'],
                ],
            ],
            [
                'code' => '35.05.10',
                'name' => 'Gandusari',
                'villages' => [
                    ['code' => '35.05.10.2001', 'name' => 'Gandusari'],
                    ['code' => '35.05.10.2002', 'name' => 'Sukoanyar'],
                ],
            ],
            [
                'code' => '35.05.11',
                'name' => 'Binangun',
                'villages' => [
                    ['code' => '35.05.11.2001', 'name' => 'Binangun'],
                    ['code' => '35.05.11.2002', 'name' => 'Rejoso'],
                ],
            ],
            [
                'code' => '35.05.12',
                'name' => 'Kesamben',
                'villages' => [
                    ['code' => '35.05.12.2001', 'name' => 'Kesamben'],
                    ['code' => '35.05.12.2002', 'name' => 'Siraman'],
                ],
            ],
            [
                'code' => '35.05.01',
                'name' => 'Wonotirto',
                'villages' => [
                    ['code' => '35.05.01.2001', 'name' => 'Wonotirto'],
                    ['code' => '35.05.01.2002', 'name' => 'Tambakrejo'],
                ],
            ],
            [
                'code' => '35.05.02',
                'name' => 'Bakung',
                'villages' => [
                    ['code' => '35.05.02.2001', 'name' => 'Bakung'],
                    ['code' => '35.05.02.2002', 'name' => 'Plandirejo'],
                ],
            ],
            [
                'code' => '35.05.03',
                'name' => 'Panggungrejo',
                'villages' => [
                    ['code' => '35.05.03.2001', 'name' => 'Panggungrejo'],
                    ['code' => '35.05.03.2002', 'name' => 'Serang'],
                ],
            ],
            [
                'code' => '35.05.04',
                'name' => 'Wates',
                'villages' => [
                    ['code' => '35.05.04.2001', 'name' => 'Wates'],
                    ['code' => '35.05.04.2002', 'name' => 'Mojorejo'],
                ],
            ],
            [
                'code' => '35.05.18',
                'name' => 'Wonodadi',
                'villages' => [
                    ['code' => '35.05.18.2001', 'name' => 'Wonodadi'],
                    ['code' => '35.05.18.2002', 'name' => 'Pikatan'],
                ],
            ],
            [
                'code' => '35.05.19',
                'name' => 'Udanawu',
                'villages' => [
                    ['code' => '35.05.19.2001', 'name' => 'Udanawu'],
                    ['code' => '35.05.19.2002', 'name' => 'Besuki'],
                ],
            ],
            [
                'code' => '35.05.20',
                'name' => 'Doko',
                'villages' => [
                    ['code' => '35.05.20.2001', 'name' => 'Doko'],
                    ['code' => '35.05.20.2002', 'name' => 'Resapombo'],
                ],
            ],
            [
                'code' => '35.05.21',
                'name' => 'Selopuro',
                'villages' => [
                    ['code' => '35.05.21.2001', 'name' => 'Selopuro'],
                    ['code' => '35.05.21.2002', 'name' => 'Popoh'],
                ],
            ],
            [
                'code' => '35.05.22',
                'name' => 'Selorejo',
                'villages' => [
                    ['code' => '35.05.22.2001', 'name' => 'Selorejo'],
                    ['code' => '35.05.22.2002', 'name' => 'Ngrendeng'],
                ],
            ],
        ];

        foreach ($districts as $districtData) {
            $villages = $districtData['villages'];
            unset($districtData['villages']);

            $district = District::firstOrCreate(
                ['code' => $districtData['code']],
                $districtData
            );

            foreach ($villages as $villageData) {
                Village::firstOrCreate(
                    ['code' => $villageData['code']],
                    array_merge($villageData, ['district_id' => $district->id])
                );
            }
        }
    }
}
