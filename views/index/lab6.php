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
        <?php $frequencyForm = ActiveForm::begin([
            'action' => ['lab6'],
            'method' => 'post',
        ]); ?>
        <?= $frequencyForm->field($model, 'text')->textarea()->label('Текст для анализа') ?>
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
        <?php $encodedFrequencyForm = ActiveForm::begin([
            'action' => ['lab6-encoded-frequency'],
            'method' => 'post',
        ]); ?>
        <?= $encodedFrequencyForm->field($model, 'encodedText')->textarea()->label('Зашифрованный текст для анализа') ?>
        <?= $encodedFrequencyForm->field($model, 'frequency')->hiddenInput(['value' => $model->serializeFrequency($model->frequency)])->label(false) ?>
        <?= $encodedFrequencyForm->field($model, 'text')->hiddenInput(['value' => $model->text])->label(false) ?>
        <?= Html::submitButton('Анализ частотности', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
        <h6>Частотность</h6>
        <div class="row">
            <?php foreach ($model->encodedFrequency as $letter => $frequency): ?>
                <div class="col-2">
                    <?= "$letter: $frequency" ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-12">
        <?php $decodeForm = ActiveForm::begin([
            'action' => ['lab6-decode'],
            'method' => 'post',
        ]); ?>
        <?= $decodeForm->field($model, 'textToDecode')->textarea()->label('Зашифрованный текст') ?>
        <?= $decodeForm->field($model, 'frequency')->hiddenInput(['value' => $model->serializeFrequency($model->frequency)])->label(false) ?>
        <?= $decodeForm->field($model, 'text')->hiddenInput(['value' => $model->text])->label(false) ?>
        <?= $decodeForm->field($model, 'encodedFrequency')->hiddenInput(['value' => $model->serializeFrequency($model->encodedFrequency)])->label(false) ?>
        <?= $decodeForm->field($model, 'encodedText')->hiddenInput(['value' => $model->encodedText])->label(false) ?>
        <?= Html::submitButton('Расшифровать', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
        <h6>Расшифрованный текст</h6>
        <div class="col-12">
            <?= $model->decodedText ?>
        </div>
    </div>
</div>
