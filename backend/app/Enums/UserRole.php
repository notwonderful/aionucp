<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';
    case CONTENT_MANAGER = 'content-manager';
    case MEMBER = 'member';

    /**
     * @return list<string>
     */
    public static function adminRoles(): array
    {
        return [
            self::SUPER_ADMIN->value,
            self::ADMIN->value,
            self::CONTENT_MANAGER->value,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => __('Super Admin'),
            self::ADMIN => __('Admin'),
            self::CONTENT_MANAGER => __('Content Manager'),
            self::MEMBER => __('Member'),
        };
    }
}
