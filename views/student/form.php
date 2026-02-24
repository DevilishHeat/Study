<?php

use app\models\Student;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Student $model
 * @var array $groupList
 * @var array $paymentTypeList
 */

$form = ActiveForm::begin();
$this->title = $model->isNewRecord ? 'Добавить студента' : 'Редактировать студента';
?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'fio') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'group_id')->widget(Select2::class, [
                'data' => $groupList,
                'options' => ['placeholder' => 'Выберите группу'],
                'pluginOptions' => ['allowClear' => false],
            ]); ?>
        <?= $form->field($model, 'payment_type_id')->widget(Select2::class, [
                'data' => $paymentTypeList,
                'options' => ['placeholder' => 'Выберите форму обучения'],
                'pluginOptions' => ['allowClear' => false],
        ]); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>