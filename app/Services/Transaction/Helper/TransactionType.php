<?php

namespace App\Services\Transaction\Helper;

class TransactionType
{
    const WEB = 1;
    const MOBILE = 2;
    const POS = 3;

    public static function getTypes(): array
    {
        return [
            self::POS => 'pos_count',
            self::WEB => 'web_count',
            self::MOBILE => 'mobile_count'
        ];
    }

    public static function getType(int $type): string
    {
        $types = self::getTypes();
        return $types[$type];
    }
}