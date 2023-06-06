<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Dealer;
use Illuminate\Database\Seeder;

class DealersTableSeeder extends Seeder
{
    public function run()
    {
        $dealers = [
            [
                'id'    => 9999,
                'name' => 'Other',
                'aliases' => 'Other',
            ],
        ];

        Dealer::insert($dealers);
    }
}
