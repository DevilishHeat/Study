<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Offers');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => [
            ['id' => 1, 'fio' => 'John Doe', 'phone' => '1234567890'],
            ['id' => 2, 'fio' => 'Jane Doe', 'phone' => '0987654321'],
        ],
    ]),
    'columns' => [
        'id',
        'fio',
        'phone'
    ],
]); ?>
