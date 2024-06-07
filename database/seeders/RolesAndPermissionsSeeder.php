<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear out existing roles and permissions
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // create permissions
        Permission::create(['name' => 'add products']);
        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'delete products']);
        
        Permission::create(['name' => 'add servicios']);
        Permission::create(['name' => 'edit servicios']);
        Permission::create(['name' => 'delete servicios']);

        Permission::create(['name' => 'add terracerias']);
        Permission::create(['name' => 'edit terracerias']);
        Permission::create(['name' => 'delete terracerias']);

        Permission::create(['name' => 'add rentacarros']);
        Permission::create(['name' => 'edit rentacarros']);
        Permission::create(['name' => 'delete rentacarros']);


        Permission::create(['name' => 'add categories']);
        Permission::create(['name' => 'edit categories']);
        Permission::create(['name' => 'delete categories']);

        Permission::create(['name' => 'add denominations']);
        Permission::create(['name' => 'edit denominations']);
        Permission::create(['name' => 'delete denominations']);

        Permission::create(['name' => 'add users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'products index']);
        Permission::create(['name' => 'categories index']);
        Permission::create(['name' => 'denominatons index']);
        
        Permission::create(['name' => 'report index']);
        Permission::create(['name' => 'cashout index']);

        // create roles and assign created permissions
        Role::create(['name' => 'Employee'])
            ->givePermissionTo('edit products');

        Role::create(['name' => 'Admin'])
            ->givePermissionTo(['edit categories', 'delete categories']);

        Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());
    }
}
