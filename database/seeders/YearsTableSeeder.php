<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Seeder;

class YearsTableSeeder extends Seeder
{
    public function run()
    {
        $years = [
            [
                'id'    => 1,
                'title' => '2021',
            ],
        ];

        Year::insert($years);
    }
}
