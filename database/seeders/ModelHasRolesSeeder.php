<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ModelHasRolesSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::find(1);
        $user2 = User::find(2);

        $role1 = Role::find(1);
        $role2 = Role::find(2);

        if ($user1 && $role1) {
            $user1->assignRole($role1);
        }

        if ($user2 && $role2) {
            $user2->assignRole($role2);
        }
    }
}

?>