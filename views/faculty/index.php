<?php

use app\models\searchModels\SpecialisationSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var SpecialisationSearch $searchModel
 */

$this->title = 'Факультеты';
?>
<div class="row">
    <div class="col-md-3">
        <a class="btn btn-primary" href="/faculty/create">Добавить</a>
    </div>
</div>
<div class="row">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]) ?>
</div>