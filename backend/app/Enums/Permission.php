<?php

declare(strict_types=1);

namespace App\Enums;

enum Permission: string
{
    // Users
    case USERS_VIEW = 'users.view';
    case USERS_EDIT = 'users.edit';
    case USERS_BALANCE_MANAGE = 'users.balance.manage';
    case USERS_ROLES_MANAGE = 'users.roles.manage';
    case USERS_BAN = 'users.ban';

    // Products
    case PRODUCTS_VIEW = 'products.view';
    case PRODUCTS_CREATE = 'products.create';
    case PRODUCTS_EDIT = 'products.edit';
    case PRODUCTS_DELETE = 'products.delete';

    // Categories
    case CATEGORIES_VIEW = 'categories.view';
    case CATEGORIES_CREATE = 'categories.create';
    case CATEGORIES_EDIT = 'categories.edit';
    case CATEGORIES_DELETE = 'categories.delete';

    // Servers
    case SERVERS_VIEW = 'servers.view';
    case SERVERS_CREATE = 'servers.create';
    case SERVERS_EDIT = 'servers.edit';
    case SERVERS_DELETE = 'servers.delete';

    // Tickets
    case TICKETS_VIEW = 'tickets.view';
    case TICKETS_REPLY = 'tickets.reply';
    case TICKETS_CLOSE = 'tickets.close';

    // Mail Items
    case MAIL_ITEMS_SEND = 'mail-items.send';

    // News
    case NEWS_VIEW = 'news.view';
    case NEWS_CREATE = 'news.create';
    case NEWS_EDIT = 'news.edit';
    case NEWS_DELETE = 'news.delete';

    // FAQ
    case FAQ_VIEW = 'faq.view';
    case FAQ_CREATE = 'faq.create';
    case FAQ_EDIT = 'faq.edit';
    case FAQ_DELETE = 'faq.delete';

    // Schedule
    case SCHEDULE_VIEW = 'schedule.view';
    case SCHEDULE_CREATE = 'schedule.create';
    case SCHEDULE_EDIT = 'schedule.edit';
    case SCHEDULE_DELETE = 'schedule.delete';

    // Settings
    case SETTINGS_VIEW = 'settings.view';
    case SETTINGS_EDIT = 'settings.edit';

    // Bulk Email
    case BULK_EMAIL_SEND = 'bulk-email.send';

    public function label(): string
    {
        return match ($this) {
            self::USERS_VIEW => __('View Users'),
            self::USERS_EDIT => __('Edit Users'),
            self::USERS_BALANCE_MANAGE => __('Manage User Balance'),
            self::USERS_ROLES_MANAGE => __('Manage User Roles'),
            self::USERS_BAN => __('Ban Users'),
            self::PRODUCTS_VIEW => __('View Products'),
            self::PRODUCTS_CREATE => __('Create Products'),
            self::PRODUCTS_EDIT => __('Edit Products'),
            self::PRODUCTS_DELETE => __('Delete Products'),
            self::CATEGORIES_VIEW => __('View Categories'),
            self::CATEGORIES_CREATE => __('Create Categories'),
            self::CATEGORIES_EDIT => __('Edit Categories'),
            self::CATEGORIES_DELETE => __('Delete Categories'),
            self::SERVERS_VIEW => __('View Servers'),
            self::SERVERS_CREATE => __('Create Servers'),
            self::SERVERS_EDIT => __('Edit Servers'),
            self::SERVERS_DELETE => __('Delete Servers'),
            self::TICKETS_VIEW => __('View Tickets'),
            self::TICKETS_REPLY => __('Reply to Tickets'),
            self::TICKETS_CLOSE => __('Close Tickets'),
            self::NEWS_VIEW => __('View News'),
            self::NEWS_CREATE => __('Create News'),
            self::NEWS_EDIT => __('Edit News'),
            self::NEWS_DELETE => __('Delete News'),
            self::SCHEDULE_VIEW => __('View Schedule'),
            self::SCHEDULE_CREATE => __('Create Schedule'),
            self::SCHEDULE_EDIT => __('Edit Schedule'),
            self::SCHEDULE_DELETE => __('Delete Schedule'),
            self::SETTINGS_VIEW => __('View Settings'),
            self::SETTINGS_EDIT => __('Edit Settings'),
            self::FAQ_VIEW => __('View FAQ'),
            self::FAQ_CREATE => __('Create FAQ'),
            self::FAQ_EDIT => __('Edit FAQ'),
            self::FAQ_DELETE => __('Delete FAQ'),
            self::MAIL_ITEMS_SEND => __('Send Mail Items'),
            self::BULK_EMAIL_SEND => __('Send Bulk Email'),
        };
    }
}
