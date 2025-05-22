<?php

/**
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 * @var \yii\web\HttpException $exception
 */

use yii\helpers\Html;

$this->title = $name;
$textColor = $exception?->statusCode === 404 ? "text-yellow" : "text-red";

?>

<div class="col-middle">
    <div class="text-center text-center">
        <h1 class="error-number"><?= $exception?->statusCode ?? null ?></h1>
        <h2><?= nl2br(Html::encode($message)) ?></h2>
        <p>
            Вышеприведённая ошибка возникла при обработке вашего запроса.
        </p>
        <p>
            Если вы считаете, что на стороне сервера есть проблемы - обратитесь к администратору.
        </p>
    </div>
</div>
