<?php

namespace proleads\documents\models\enums;

use yii\base\BaseObject;

class ResultTypeEnum extends BaseObject
{
    const HTML = 'html';
    const FILE = 'file';
    const BROWSER = 'browser';

    public static function getAllTitles(): array
    {
        return [
            self::HTML => 'html',
            self::FILE => 'файл',
            self::BROWSER => 'browser',
        ];
    }
}