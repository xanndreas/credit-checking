<?php

namespace Database\Seeders;

use App\Models\Insurance;
use Illuminate\Database\Seeder;

class InsurancesTableSeeder extends Seeder
{
    public function run()
    {
        $insurances = [
            [
                'id'    => 1,
                'name' => 'Insurances Test',
                'slug' => 'insurances-test',
            ],
        ];

        Insurance::insert($insurances);
    }
}
