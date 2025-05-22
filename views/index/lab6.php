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
        <?= $encodeForm->field($model, 'frequency')->hiddenInput(['value' => $model->frequency])->label(false) ?>
        <?= $encodeForm->field($model, 'text')->hiddenInput(['value' => $model->text])->label(false) ?>
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
        <?php $encodeForm = ActiveForm::begin([
            'action' => ['lab6-decode'],
            'method' => 'post',
        ]); ?>
        <?= $encodeForm->field($model, 'textToDecode')->textarea()->label('Зашифрованный текст') ?>
        <?= $encodeForm->field($model, 'frequency')->hiddenInput(['value' => $model->frequency])->label(false) ?>
        <?= $encodeForm->field($model, 'text')->hiddenInput(['value' => $model->text])->label(false) ?>
        <?= $encodeForm->field($model, 'encodedFrequency')->hiddenInput(['value' => $model->encodedFrequency])->label(false) ?>
        <?= $encodeForm->field($model, 'encodedText')->hiddenInput(['value' => $model->encodedText])->label(false) ?>
        <?= Html::submitButton('Расшифровать', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
        <h6>Расшифрованный текст</h6>
        <div class="col-12">
            <?= $model->decodedText ?>
        </div>
    </div>
</div>
