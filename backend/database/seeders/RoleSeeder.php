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

        // Admin — all permissions
        $admin = Role::findOrCreate(UserRole::ADMIN->value);
        $admin->syncPermissions(array_column(Permission::cases(), 'value'));

        // Content Manager — products and categories only
        $contentManager = Role::findOrCreate(UserRole::CONTENT_MANAGER->value);
        $contentManager->syncPermissions([
            Permission::PRODUCTS_VIEW->value,
            Permission::PRODUCTS_CREATE->value,
            Permission::PRODUCTS_EDIT->value,
            Permission::CATEGORIES_VIEW->value,
            Permission::CATEGORIES_CREATE->value,
            Permission::CATEGORIES_EDIT->value,
            Permission::NEWS_VIEW->value,
            Permission::NEWS_CREATE->value,
            Permission::NEWS_EDIT->value,
            Permission::FAQ_VIEW->value,
            Permission::FAQ_CREATE->value,
            Permission::FAQ_EDIT->value,
            Permission::WIKI_VIEW->value,
            Permission::WIKI_CREATE->value,
            Permission::WIKI_EDIT->value,
            Permission::SCHEDULE_VIEW->value,
            Permission::SCHEDULE_CREATE->value,
            Permission::SCHEDULE_EDIT->value,
            Permission::SETTINGS_VIEW->value,
        ]);

        // Member — no admin permissions
        Role::findOrCreate(UserRole::MEMBER->value);
    }
}
