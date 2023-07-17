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
                'id'    => 1,
                'name' => 'Other',
                'aliases' => 'zzother',
            ],
            [
                'id'    => 2,
                'name' => 'Honda',
                'aliases' => 'honda',
            ],
        ];

        Brand::insert($brands);
    }
}
