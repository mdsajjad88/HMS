<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GeoDivisions; // Import your GeoDivisions model

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = [
            [
                'id' => 1,
                'division_name_eng' => 'Chattagram',
                'division_name_bng' => 'চট্টগ্রাম',
                'bbs_code' => 'CHT',
                'status' => true,
                'created_by' => null,
                'modified_by' => null,
            ],
            [
                'id' => 2,
                'division_name_eng' => 'Rajshahi',
                'division_name_bng' => 'রাজশাহী',
                'bbs_code' => 'RAJ',
                'status' => true,
                'created_by' => null,
                'modified_by' => null,
            ],
            [
                'id' => 3,
                'division_name_eng' => 'Khulna',
                'division_name_bng' => 'খুলনা',
                'bbs_code' => 'KHL',
                'status' => true,
                'created_by' => null,
                'modified_by' => null,
            ],
            [
                'id' => 4,
                'division_name_eng' => 'Barisal',
                'division_name_bng' => 'বরিশাল',
                'bbs_code' => 'BAR',
                'status' => true,
                'created_by' => null,
                'modified_by' => null,
            ],
            [
                'id' => 5,
                'division_name_eng' => 'Sylhet',
                'division_name_bng' => 'সিলেট',
                'bbs_code' => 'SYL',
                'status' => true,
                'created_by' => null,
                'modified_by' => null,
            ],
            [
                'id' => 6,
                'division_name_eng' => 'Dhaka',
                'division_name_bng' => 'ঢাকা',
                'bbs_code' => 'DHK',
                'status' => true,
                'created_by' => null,
                'modified_by' => null,
            ],
            [
                'id' => 7,
                'division_name_eng' => 'Rangpur',
                'division_name_bng' => 'রংপুর',
                'bbs_code' => 'RNG',
                'status' => true,
                'created_by' => null,
                'modified_by' => null,
            ],
            [
                'id' => 8,
                'division_name_eng' => 'Mymensingh',
                'division_name_bng' => 'ময়মনসিংহ',
                'bbs_code' => 'MYM',
                'status' => true,
                'created_by' => null,
                'modified_by' => null,
            ],
        ];

        foreach ($divisions as $division) {
            GeoDivisions::create($division);
        }
    }
}
