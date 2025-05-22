<?php

use app\models\Lab6Model;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var Lab6Model $model
 */

?>

<div class="row">
    <div class="col-12">
        <?php $encodeForm = ActiveForm::begin([
            'action' => ['lab6'],
            'method' => 'post',
        ]); ?>
        <?= $encodeForm->field($model, 'text')->textarea()->label('Текст для анализа') ?>
        <?= Html::submitButton('Анализ частотности', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
        <h6>Частотность</h6>
        <div class="row">
            <?php foreach ($model->frequency as $letter => $frequency): ?>
                <div class="col-2">
                    <?= "$letter: $frequency" ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-12">
        <?php $encodeForm = ActiveForm::begin([
            'action' => ['lab6-encoded-frequency'],
            'method' => 'post',
        ]); ?>
        <?= $encodeForm->field($model, 'encodedText')->textarea()->label('Зашифрованный текст для анализа') ?>
        <?= Html::submitButton('Анализ частотности', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
        <h6>Частотность</h6>
        <?php foreach ($model->encodedFrequency as $letter => $frequency): ?>
            <div class="col-2">
                <?= "$letter: $frequency" ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="col-12">
        <?php $encodeForm = ActiveForm::begin([
            'action' => ['lab6-decode'],
            'method' => 'post',
        ]); ?>
        <?= $encodeForm->field($model, 'textToDecode')->textarea()->label('Зашифрованный текст') ?>
        <?= Html::submitButton('Расшифровать', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
        <h6>Расшифрованный текст</h6>
        <div class="col-12">
            <?= $model->decodedText ?>
        </div>
    </div>
</div>
