<?php

namespace proleads\documents\models\generation\root\input;

use yii\base\BaseObject;

class ContentObject extends BaseObject
{
    public ?string $content = null;
    public ?string $type = null;

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}