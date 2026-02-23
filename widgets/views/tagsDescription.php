<?php

use app\models\tags\TagCollection;
use yii\base\View;
use yii\helpers\Html;

/**
 * @var View $this
 * @var TagCollection $tagCollection
 */

$content = Html::tag('h3', 'Доступные теги', ['class' => 'text-center']);
foreach ($tagCollection->groups as $group) {
    if (!$group->fields) {
        continue;
    }
    $content .= Html::tag('h5', "Теги из $group->description", ['class' => 'text-center', 'style' => 'color: black']);
    $content .= Html::beginTag('div', ['class' => 'row']);
    foreach ($group->fields as $field) {
        $content .= "<b>{$group->getFieldAlias($field)}</b> - {$field->description}";
    }
    $content .= Html::endTag('div');
}

echo $content;