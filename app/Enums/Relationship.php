<?php

namespace App\Enums;

enum Relationship: int
{
    case Single = 1;
    case Married = 2;
    case Relationship = 3;
    case DIVORCED = 4;
    case Other = 10;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::Single => 'مجرد',
            self::Married => 'متأهل',
            self::Relationship => 'در رابطه',
            self::DIVORCED => 'مطلقه',
            self::Other => 'سایر',
        };
    }

    public static function labelFor(int $value): string
    {
        return self::from($value)->label();
    }
}
