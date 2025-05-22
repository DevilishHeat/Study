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
        <?php $keysForm = ActiveForm::begin([
            'action' => ['lab8'],
            'method' => 'post',
        ]); ?>
        <?= $keysForm->field($model, 'p')->textInput() ?>
        <?= $keysForm->field($model, 'q')->textInput() ?>
        <?= Html::submitButton('Сгенерировать ключи', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-5">
        <h6>Публичный ключ</h6>
        <label>e</label>
        <div class="border">
            <?= $model->e ?>
        </div>
        <label>n</label>
        <div class="border">
            <?= $model->n ?>
        </div>
        <h6>Приватный ключ</h6>
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