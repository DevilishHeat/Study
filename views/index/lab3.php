<?php

use app\models\Lab3Model;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var Lab3Model $model
 * @var string $encoded
 * @var string $decoded
 */

?>

<div class="row">
    <div class="col-5">
        <?php $encodeForm = ActiveForm::begin([
            'action' => ['lab3'],
            'method' => 'post',
        ]); ?>
        <?= $encodeForm->field($model, 'key')->textInput()->label('Ключ') ?>
        <?= $encodeForm->field($model, 'decoded')->textInput()->label('Текст') ?>
        <?= Html::submitButton('Закодировать', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
        <div>
            Закодированный текст: <?= $model->encoded ?>
        </div>
    </div>
    <div class="col-5">
        <?php $decodedForm = ActiveForm::begin([
            'action' => ['lab3-decode'],
            'method' => 'post',
        ]); ?>
        <?= $decodedForm->field($model, 'key')->textInput()->label('Ключ') ?>
        <?= $decodedForm->field($model, 'encoded')->textInput()->label('Текст') ?>
        <?= Html::submitButton('Раскодировать', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
        <div>
            Раскодированный текст: <?= $model->decoded ?>
        </div>
    </div>
</div>
