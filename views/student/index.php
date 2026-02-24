<?php

use app\models\enums\PaymentTypeEnum;
use app\models\searchModels\StudentSearch;
use app\models\Student;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var StudentSearch $searchModel

 */

$this->title = 'Студенты';
?>
<div class="row">
    <div class="col-md-3">
        <a class="btn btn-primary" href="/student/create">Добавить</a>
    </div>
</div>
<div class="row">
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'fio',
        'phone',
        'group_id' => ['label' => 'Группа', 'value' => function (Student $model) {
            return $model->group ? $model->group->number : '';
        }],
        'payment_type_id' => ['label' => 'Тип оплаты', 'value' => function (Student $model) {
            return PaymentTypeEnum::getList()[$model->payment_type_id] ?? '';
        }],
        'faculty' => ['label' => 'Факультет', 'value' => function (Student $model) {
            return $model->group->faculty->name ?? '';
        }],
        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
</div>