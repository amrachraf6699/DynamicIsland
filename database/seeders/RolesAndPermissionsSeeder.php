<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Create CRUD permissions for each configured admin resource
        $resources = collect(config('admin.resources', []))
            ->filter(fn ($resource) => ($resource['route'] ?? null) !== 'admin.dashboard')
            ->values();

        $permissions = [];

        foreach ($resources as $resource) {
            $route = $resource['route'] ?? null;
            if (! $route) {
                continue;
            }

            // Extract resource key from route like "admin.pages.index" => "pages"
            $parts = explode('.', $route);
            $resourceKey = $parts[1] ?? Str::slug($resource['label'] ?? 'resource');

            foreach (['create', 'read', 'update', 'delete'] as $action) {
                $name = "$resourceKey.$action";
                $permissions[] = Permission::firstOrCreate(
                    ['name' => $name, 'guard_name' => 'web']
                );
            }
        }

        // Settings groups permissions (read/update)
        foreach (['analytics', 'contact', 'mail', 'social', 'notifications', 'website'] as $group) {
            foreach (['read', 'update'] as $action) {
                $permissions[] = Permission::firstOrCreate([
                    'name' => "settings.$group.$action",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Roles & users CRUD permissions
        foreach (['roles', 'users'] as $entity) {
            foreach (['create', 'read', 'update', 'delete'] as $action) {
                $permissions[] = Permission::firstOrCreate([
                    'name' => "$entity.$action",
                    'guard_name' => 'web',
                ]);
            }
        }

        foreach (['contacts', 'newsletters'] as $entity) {
            foreach (['create', 'read', 'update', 'delete'] as $action) {
                $permissions[] = Permission::firstOrCreate([
                    'name' => "$entity.$action",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Create Super-Admin role with all permissions
        $role = Role::firstOrCreate(['name' => 'Super-Admin', 'guard_name' => 'web']);
        $role->syncPermissions($permissions);

        // Optionally assign role to the first user if present
        $userModel = config('auth.providers.users.model');
        if (class_exists($userModel)) {
            $user = $userModel::query()->first();
            if ($user) {
                $user->assignRole($role);
            }
        }
    }
}
