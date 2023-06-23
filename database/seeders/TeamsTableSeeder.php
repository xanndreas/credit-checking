<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    public function run()
    {
        $teams = [
            [
                'id'             => 1,
                'owner_id'       => 2,
                'slug'           => 'aSfcs',
            ],
        ];

        Team::insert($teams);
    }
}
