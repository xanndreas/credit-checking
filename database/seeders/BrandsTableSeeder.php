<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            [
                'id'    => 9999,
                'name' => 'Other',
                'aliases' => 'Other',
            ],
        ];

        Brand::insert($brands);
    }
}
