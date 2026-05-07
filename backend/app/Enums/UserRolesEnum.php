<?php

namespace App\Enums;

enum UserRolesEnum: string
{
    case ADMIN = 'admin';
    case HR = 'hr';
    case MANAGER = 'manager';
    case EMPLOYEE = 'employee';

    public function canAccessAdmin(): bool
    {
        return match($this) {
            self::ADMIN, self::MANAGER => true,
            self::EMPLOYEE             => false,
        };
    }
}
