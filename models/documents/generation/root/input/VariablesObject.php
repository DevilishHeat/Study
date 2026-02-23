<?php

namespace proleads\documents\models\generation\root\input;

use Yii;
use yii\base\BaseObject;

class VariablesObject extends BaseObject
{
    public array $variables = [];

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }
}