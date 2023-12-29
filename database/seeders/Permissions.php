<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit']);
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'add']);
        Permission::create(['name' => 'read']);

        Role::create(['name'=> 'admin']);
        Role::create(['name'=> 'user']);

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('edit');
        $roleAdmin->givePermissionTo('delete');
        $roleAdmin->givePermissionTo('add');
        $roleAdmin->givePermissionTo('read');
        
        $roleUser = Role::findByName('user');
        $roleUser->givePermissionTo('read');
        $roleUser->givePermissionTo('add');
    }
}
