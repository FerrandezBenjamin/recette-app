<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Admin',
            'surname' => 'Nimda',
            'email' => 'admin@admin.com',
        ]);

        User::factory()->create([
            'name' => 'Utilisateur',
            'surname' => 'Ruetasilitu',
            'email' => 'user@user.com',
        ]);

        $this->call(RoleSeeder::class);
        $this->call(ModelHasRolesSeeder::class);

    }
}
