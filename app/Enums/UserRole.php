<?php

namespace App\Enums;

enum UserRole: int
{
    case SuperVisor = 1;
    case Manager = 2;
    case Employee = 3;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return array_column(self::cases(), 'name');
    }
}
