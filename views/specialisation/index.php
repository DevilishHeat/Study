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

$this->title = 'Специальности';
?>
<div class="row">
    <div class="col-md-3">
        <a class="btn btn-primary" href="/specialisation/create">Добавить</a>
    </div>
</div>
<div class="row">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'code',
            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]) ?>
</div>