<?php

namespace proleads\documents\models\generation\root\input;

use proleads\helps\common\interfaces\EnumInterface;
use yii\base\BaseObject;

class ContentTypeEnum extends BaseObject implements EnumInterface
{
    const SITE = 'site-document';
    const LOAN_REQUEST = 'lead-document-type';

    public static function getAllTitles(): array
    {
        return [
            self::SITE => 'Сайт',
            self::LOAN_REQUEST => 'Заявка',
        ];
    }
}