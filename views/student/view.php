<?php

use app\models\Student;
use yii\web\View;
use yii\widgets\DetailView;

/**
 * @var View $this
 * @var Student $model
 */

$this->title = $model->fio;
?>
<div class="row">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fio',
            'phone',
            'group_id',
            'payment_type_id',
        ],
    ]) ?>
</div>