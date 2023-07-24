<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        // create permissions
        $arrayPermissions = [
            'edit user',
            'add user',
            'list user',
            'detele user',
            'list post',
            'edit post',
            'add post',
            'delete post',
            'list categorypost',
            'edit categorypost',
            'add categorypost',
            'delete categorypost',
            'list postcomment',
            'edit postcomment',
            'add postcomment',
            'delete postcomment',
            'list demo',
            'add demo',
            'delete demo',
            'edit demo',
            'list configure',
            'add configure',
            'delete configure',
            'edit configure',
            'list langcustom',
            'add langcustom',
            'delete langcustom',
            'edit langcustom',
            'list redirect',
            'add redirect',
            'edit redirect',
            'delete redirect',
            'list seo',
            'add seo',
            'delete seo',
            'edit seo',
            'list menu',
            'edit menu',
            'add menu',
            'delete menu',
        ];

        foreach ($arrayPermissions as $key => $value) {
            Permission::create(['name' => $value]);
        }
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
        $user = User::find(1);
        $user->syncRoles('super-admin');
    }
}
