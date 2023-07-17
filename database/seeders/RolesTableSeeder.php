<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Admin',
            ],
            [
                'id'    => 2,
                'title' => 'Marketing Head',
            ],
            [
                'id'    => 3,
                'title' => 'Area Manager',
            ],
            [
                'id'    => 4,
                'title' => 'Branch Manager',
            ],
            [
                'id'    => 5,
                'title' => 'Auto Planner',
            ],
            [
                'id'    => 6,
                'title' => 'Surveyor Admin',
            ],
            [
                'id'    => 7,
                'title' => 'Surveyor',
            ],
        ];

        Role::insert($roles);
    }
}
