<?php

use app\models\Lab8Model;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var Lab8Model $model
 */

?>

<div class="row">
    <div class="col-5">
        <?php $encodeForm = ActiveForm::begin([
            'action' => ['lab8'],
            'method' => 'post',
        ]); ?>
        <?= $encodeForm->field($model, 'p')->textInput() ?>
        <?= $encodeForm->field($model, 'q')->textInput() ?>
        <?= Html::submitButton('Сгенерировать ключи', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-5">
        <label>Публичный ключ</label>
        <label>e</label>
        <div class="border">
            <?= $model->e ?>
        </div>
        <label>n</label>
        <div class="border">
            <?= $model->n ?>
        </div>
        <label>Приватный ключ</label>
        <label>d</label>
        <div class="border">
            <?= $model->d ?>
        </div>
        <label>n</label>
        <div class="border">
            <?= $model->n ?>
        </div>
    </div>
</div>