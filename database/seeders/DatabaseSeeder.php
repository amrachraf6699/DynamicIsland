<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Ensure at least one user exists
        if (! \App\Models\User::query()->exists()) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
            ]);
        }

        // Seed roles and permissions (creates Super-Admin and grants all permissions)
        $this->call(RolesAndPermissionsSeeder::class);

        // Seed default settings groups/keys
        $this->call(SettingsSeeder::class);

        // Seed contacts demo data
        $this->call(ContactSeeder::class);

        // Seed services and sample requests
        $this->call(ServiceSeeder::class);

        // Seed newsletter subscribers
        $this->call(NewsletterSeeder::class);
    }
}
