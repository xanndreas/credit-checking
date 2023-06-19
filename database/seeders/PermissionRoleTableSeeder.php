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

        $user_permissions = $admin_permissions->filter(function ($permission) {
            return !str_starts_with($permission->title, 'user_') && !str_starts_with($permission->title, 'role_') && !str_starts_with($permission->title, 'permission_');
        })->pluck('id')->toArray();

        Role::findOrFail(2)->permissions()->sync(array_merge($user_permissions, [72]));

        Role::findOrFail(3)->permissions()->sync(array_merge($user_permissions, [73]));

        Role::findOrFail(4)->permissions()->sync(array_merge($user_permissions, [74]));

        Role::findOrFail(5)->permissions()->sync(array_merge($user_permissions, [75]));
    }
}
