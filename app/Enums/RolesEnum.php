<?php

namespace App\Enums;

enum RolesEnum: string
{
    case ADMIN_ONE = 'admin_one';
    case ADMIN_TWO = 'admin_two';
    case ADMIN_THREE = 'admin_three';
    case SUPER_ADMIN = 'super_admin';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN_ONE => 'ادمین یک',
            self::ADMIN_TWO => 'ادمین دو',
            self::ADMIN_THREE => 'ادمین سه',
            self::SUPER_ADMIN => 'ادمین کل',
        };
    }
}
