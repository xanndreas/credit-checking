<?php

namespace Database\Seeders;

use App\Models\Tenor;
use Illuminate\Database\Seeder;

class TenorsTableSeeder extends Seeder
{
    public function run()
    {
        $tenors = [
            [
                'id'    => 1,
                'year' => 2,
            ],
        ];

        Tenor::insert($tenors);
    }
}
