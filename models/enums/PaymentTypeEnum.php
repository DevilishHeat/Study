<?php

namespace app\models\enums;

class PaymentTypeEnum
{
    public const FREE = 1;
    public const PAID = 2;

    public static function getList()
    {
        return [
            self::FREE => 'Бюджетная',
            self::PAID => 'Платная',
        ];
    }
}