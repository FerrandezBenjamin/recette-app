<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        User::factory()->create([
            'name' => 'Utilisateur',
            'email' => 'user@user.com',
        ]);

        $this->call(RoleSeeder::class);
        $this->call(ModelHasRolesSeeder::class);

    }
}
