<?php

use app\models\searchModels\GroupSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var GroupSearch $searchModel

 */
$this->title = 'Группы';
?>
<div class="row">
    <div class="col-md-3">
        <a class="btn btn-primary" href="/group/create">Добавить</a>
    </div>
</div>

<div class="row">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'number',
            'course' => ['label' => 'Курс', 'value' => function ($model) {
                return $model->getCourse();
            }],
            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]) ?>
</div>