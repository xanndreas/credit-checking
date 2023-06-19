<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'approved'       => 1,
            ],
            [
                'id'             => 2,
                'name'           => 'Marketing Head 1',
                'email'          => 'marketinghead1@local.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'approved'       => 1,
            ],
            [
                'id'             => 3,
                'name'           => 'Marketing Head 2',
                'email'          => 'marketinghead2@local.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'approved'       => 1,
            ],
            [
                'id'             => 4,
                'name'           => 'Area Manager 1',
                'email'          => 'areamanager1@local.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'approved'       => 1,
            ],
            [
                'id'             => 5,
                'name'           => 'Area Manager 2',
                'email'          => 'areamanager2@local.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'approved'       => 1,
            ],
            [
                'id'             => 6,
                'name'           => 'Branch Manager 1',
                'email'          => 'branchmanager1@local.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'approved'       => 1,
            ],
            [
                'id'             => 7,
                'name'           => 'Branch Manager 2',
                'email'          => 'branchmanager2@local.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'approved'       => 1,
            ],
            [
                'id'             => 8,
                'name'           => 'Auto Planner 1',
                'email'          => 'autoplanner1@local.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'approved'       => 1,
            ],
            [
                'id'             => 9,
                'name'           => 'Auto Planner 2',
                'email'          => 'autoplanner2@local.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'approved'       => 1,
            ],
        ];

        User::insert($users);
    }
}
