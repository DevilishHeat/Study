<?php
use app\models\Specialisation;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/**
 * @var View $this
 * @var Specialisation $model
 */
$this->title = $model->name;
?>

<div class="row">
    <div class="col-md-12">
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data' => ['confirm' => 'Вы уверены, что хотите удалить эту специальность?']]) ?>
    </div>
    <div class="col-md-12">
        <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'code',
                ],
        ]) ?>
    </div>
</div>