<?php

namespace proleads\documents\models\generation\model;

use proleads\documents\models\generation\root\input\ContentObject;
use proleads\documents\models\generation\root\input\VariablesObject;

class BaseDocumentGenerator extends ModelDocumentGenerator
{
    public string $content;

    public array $variables;

    public function getContent(): ContentObject
    {
        return new ContentObject([
            'content' => $this->content,
        ]);
    }

    public function getVariables(): VariablesObject
    {
        return new VariablesObject([
            'variables' => $this->variables,
        ]);
    }
}