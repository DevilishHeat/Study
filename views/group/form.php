<?php
use app\models\Group;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Group $model
 * @var array $specialisationList
 */
$this->title = $model->isNewRecord ? 'Создание группы' : 'Редактирование группы ' . $model->number;

$form = ActiveForm::begin();
?>

<div class="row col-md-8">
    <div class="col-md-12">
        <?= $form->field($model, 'number') ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'start_date') ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'specialisation_id')->widget(Select2::class, [
                'data' => $specialisationList,
                'options' => ['placeholder' => 'Выберите направление'],
                'pluginOptions' => ['allowClear' => false],
            ]); ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'faculty_id')->widget(Select2::class, [
                'data' => $facultyList,
                'options' => ['placeholder' => 'Выберите факультет'],
                'pluginOptions' => ['allowClear' => false],
        ]); ?>
    </div>
    <div class="col-md-12">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>