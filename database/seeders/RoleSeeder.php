<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::firstOrCreate(['name' => 'creation plat']);
        Permission::firstOrCreate(['name' => 'suppression plat']);

        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->givePermissionTo(['creation plat', 'suppression plat']);
        
        $userRole = Role::firstOrCreate(['name' => 'Utilisateur']);
    }
}
