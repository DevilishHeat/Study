<?php
use app\models\DocumentTemplate;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var View $this
 * @var DocumentTemplate $model
 */

$this->title = $model->isNewRecord ? 'Создание факультета' : 'Редактирование факультета ' . $model->title;
$form = ActiveForm::begin();
?>
    <div class="row col-md-8">
        <div class="col-md-12">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'template') ?>
        </div>
        <div class="col-md-12">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>