<?php

use app\models\DocumentTemplate;
use yii\widgets\DetailView;

/**
 * @var $model DocumentTemplate
 */

$this->title = $model->title;
?>
<div class="col-md-12">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'template',
            'created_at',
            'updated_at',
        ],
    ]) ?>
</div>

