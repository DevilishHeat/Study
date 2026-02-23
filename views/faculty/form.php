<?php

use app\models\Faculty;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Faculty $model
 */

$this->title = $model->isNewRecord ? 'Создание факультета' : 'Редактирование факультета ' . $model->name;
$form = ActiveForm::begin();
?>
    <div class="row col-md-8">
        <div class="col-md-12">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-md-12">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>