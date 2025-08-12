<?php

namespace App\Enums;

enum Relationship: int
{
    case Single       = 1;
    case Married      = 2;
    case Relationship = 3;
    case Other        = 4;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::Single       => 'مجرد',
            self::Married      => 'متأهل',
            self::Relationship => 'در رابطه',
            self::Other        => 'سایر',
        };
    }
}
