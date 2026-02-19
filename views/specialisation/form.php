<?php

use app\models\Specialisation;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Specialisation $model
 */

$form = ActiveForm::begin();
?>

<div class="row col-md-8">
    <div class="col-md-12">
        <?= $form->field($model, 'name') ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'code') ?>
    </div>

    <div class="col-md-12">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>