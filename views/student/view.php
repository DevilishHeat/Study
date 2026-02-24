<?php

use app\models\enums\PaymentTypeEnum;
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
            'group_id' => ['label' => 'Группа', 'value' => $model->group->number],
            'payment_type_id' => [
                    'label' => 'Тип оплаты',
                    'value' => PaymentTypeEnum::getList()[$model->payment_type_id],
            ],
        ],
    ]) ?>
</div>