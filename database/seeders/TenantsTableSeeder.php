<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class TenantsTableSeeder extends Seeder
{
    public function run()
    {
        $tenants = [
            [
                'id'             => 1,
                'slug'           => 'vqwsa',
                'team_id'        => 1,
                'parent_id'      => 2,
                'user_id'        => 3,
            ],
            [
                'id'             => 2,
                'slug'           => 'ascsa',
                'team_id'        => 1,
                'parent_id'      => 2,
                'user_id'        => 4,
            ],
            // bm
            [
                'id'             => 3,
                'slug'           => 'lklas',
                'team_id'        => 1,
                'parent_id'      => 3,
                'user_id'        => 5,
            ],
            [
                'id'             => 4,
                'slug'           => 'kpass',
                'team_id'        => 1,
                'parent_id'      => 3,
                'user_id'        => 6,
            ],
            [
                'id'             => 5,
                'slug'           => 'zxcqs',
                'team_id'        => 1,
                'parent_id'      => 4,
                'user_id'        => 7,
            ],
            // ap

            [
                'id'             => 6,
                'slug'           => 'asd2q',
                'team_id'        => 1,
                'parent_id'      => 5,
                'user_id'        => 8,
            ],
            [
                'id'             => 7,
                'slug'           => 'abwqw',
                'team_id'        => 1,
                'parent_id'      => 5,
                'user_id'        => 9,
            ],
            [
                'id'             => 8,
                'slug'           => 'abvss',
                'team_id'        => 1,
                'parent_id'      => 6,
                'user_id'        => 10,
            ],
            [
                'id'             => 9,
                'slug'           => 'hwaed',
                'team_id'        => 1,
                'parent_id'      => 6,
                'user_id'        => 11,
            ],
            [
                'id'             => 10,
                'slug'           => 'dfhds',
                'team_id'        => 1,
                'parent_id'      => 7,
                'user_id'        => 12,
            ],
            [
                'id'             => 11,
                'slug'           => 'acvas',
                'team_id'        => 1,
                'parent_id'      => 7,
                'user_id'        => 13,
            ],
        ];

        Tenant::insert($tenants);
    }
}
