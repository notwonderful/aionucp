<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Permission;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Models\Role;

final class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create all permissions from enum
        foreach (Permission::cases() as $permission) {
            SpatiePermission::findOrCreate($permission->value);
        }

        // Super Admin — all permissions
        $superAdmin = Role::findOrCreate(UserRole::SUPER_ADMIN->value);
        $superAdmin->syncPermissions(array_column(Permission::cases(), 'value'));

        // Admin — everything except server management
        $admin = Role::findOrCreate(UserRole::ADMIN->value);
        $admin->syncPermissions(
            collect(Permission::cases())
                ->filter(fn (Permission $p) => ! str_starts_with($p->value, 'servers.'))
                ->pluck('value')
                ->toArray()
        );

        // Content Manager — products and categories only
        $contentManager = Role::findOrCreate(UserRole::CONTENT_MANAGER->value);
        $contentManager->syncPermissions([
            Permission::PRODUCTS_VIEW->value,
            Permission::PRODUCTS_CREATE->value,
            Permission::PRODUCTS_EDIT->value,
            Permission::CATEGORIES_VIEW->value,
            Permission::CATEGORIES_CREATE->value,
            Permission::CATEGORIES_EDIT->value,
        ]);

        // Member — no admin permissions
        Role::findOrCreate(UserRole::MEMBER->value);
    }
}
