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
        $bm = [66, 67, 68, 69, 70, 74, 84, 85];
        $ap = [66, 67, 68, 69, 70, 75, 83, 84, 85, 87, 88, 89];

        $sv = [66, 68, 70, 84, 85, 88, 89, 93, 94];
        $sva = [66, 68, 70, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 95];

        Role::findOrFail(2)->permissions()->sync($mh);

        Role::findOrFail(3)->permissions()->sync($am);

        Role::findOrFail(4)->permissions()->sync($bm);

        Role::findOrFail(5)->permissions()->sync($ap);

        Role::findOrFail(6)->permissions()->sync($sva);

        Role::findOrFail(7)->permissions()->sync($sv);
    }
}
