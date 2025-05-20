<?php

use app\models\Lab2Model;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var Lab2Model $model
 */

?>

<div class="row">
    <div class="col-5">
        <?php $encodeForm = ActiveForm::begin([
            'action' => ['lab2'],
            'method' => 'post',
        ]); ?>
        <?= $encodeForm->field($model, 'decoded')->textInput()->label('Текст') ?>
        <?= Html::submitButton('Зашифровать', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-5">
        <?php $decodedForm = ActiveForm::begin([
            'action' => ['lab2-decode'],
            'method' => 'post',
        ]); ?>
        <?= $decodedForm->field($model, 'encoded')->textInput()->label('Текст') ?>
        <?= Html::submitButton('Расшифровать', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

