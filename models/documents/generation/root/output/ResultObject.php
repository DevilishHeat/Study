<?php

namespace proleads\documents\models\generation\root\output;

use yii\base\BaseObject;

class ResultObject extends BaseObject
{
    public ?string $result = null;

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }
}