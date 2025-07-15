<?php

namespace App\Enums;

enum RolesEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public static function permissions()
    {
        return [
            self::ADMIN->value => [],
            self::USER->value => [
                'see_favorites',
                'add_favorites',
                'remove_favorites'
            ]
        ];
    }
}
