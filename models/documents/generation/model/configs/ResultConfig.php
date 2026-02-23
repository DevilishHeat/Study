<?php

namespace proleads\documents\models\generation\model\configs;

use proleads\documents\models\enums\ResultTypeEnum;
use yii\base\BaseObject;

class ResultConfig extends BaseObject
{
    public string $type = ResultTypeEnum::FILE;
}