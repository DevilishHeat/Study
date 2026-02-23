<?php

use app\models\searchModels\DocumentTemplateSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\View;

/**
 * @var $this View
 * @var $searchModel DocumentTemplateSearch
 * @var $dataProvider ActiveDataProvider
 */

$this->title = 'Шаблоны документов';
?>
<div class="row">
    <div class="col-md-3">
        <a class="btn btn-primary" href="/document-template/create">Добавить</a>
    </div>
</div>
<div class="col-md-12">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            'created_at',
            'updated_at',
            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]) ?>
</div>