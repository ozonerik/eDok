<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // create permissions
        Permission::create(['name' => 'Create.*']);
        Permission::create(['name' => 'Read.*']);
        Permission::create(['name' => 'Update.*']);
        Permission::create(['name' => 'Delete.*']);

        // this can be done as separate statements
        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo(Permission::all());

        // this can be done as separate statements
        $role = Role::create(['name' => 'User']);
        $role->givePermissionTo(['Read.*']);
    }
}
