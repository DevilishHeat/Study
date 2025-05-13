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
    <?php $encodeForm = ActiveForm::begin([
        'action' => ['lab3'],
        'method' => 'post',
    ]); ?>
    <div class="col-6">
        <?= $encodeForm->field($model, 'key')->textInput() ?>
        <?= $encodeForm->field($model, 'decoded')->textInput() ?>
        <?= Html::submitButton('Закодировать', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="col-6">
        <?php $encodeForm = ActiveForm::begin([
            'action' => ['lab3-decode'],
            'method' => 'post',
        ]); ?>
        <div class="col-6">
            <?= $encodeForm->field($model, 'key')->textInput() ?>
            <?= $encodeForm->field($model, 'encoded')->textInput() ?>
            <?= Html::submitButton('Раскодировать', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
