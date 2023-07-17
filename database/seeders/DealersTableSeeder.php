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
                'id'    => 1,
                'name' => 'Other',
                'aliases' => 'zzother',
            ],
            [
                'id'    => 2,
                'name' => 'Dealer Test',
                'aliases' => 'dealer-test',
            ],
        ];

        Dealer::insert($dealers);
    }
}
