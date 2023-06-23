<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));

        $mh = [65, 66, 67, 68, 69, 70, 72, 76, 77, 78, 79, 80];
        $am = [66, 67, 68, 69, 70, 73];
        $bm = [66, 67, 68, 69, 70, 74];
        $ap = [66, 67, 68, 69, 70, 75];

        Role::findOrFail(2)->permissions()->sync($mh);

        Role::findOrFail(3)->permissions()->sync($am);

        Role::findOrFail(4)->permissions()->sync($bm);

        Role::findOrFail(5)->permissions()->sync($ap);
    }
}
