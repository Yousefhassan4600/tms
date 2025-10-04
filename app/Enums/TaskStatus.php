<?php

namespace App\Enums;

enum TaskStatus: int
{
    case New = 1;
    case Reviewed = 2;
    case Holding = 3;
    case Approved = 4;
    case Rejected = 5;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return array_column(self::cases(), 'name');
    }

    public function label(): string
    {
        return match($this) {
            self::New => __("جديد"),
            self::Reviewed => __("تم المراجعة"),
            self::Holding => __("قيد الانتظار"),
            self::Approved => __("تم الموافقة"),
            self::Rejected => __("تم الرفض"),
        };
    }
}
