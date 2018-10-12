<?php

use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $model backend\models\Spu */

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'mode',
            'value' => $model->lookup('mode'),
        ],
        [
            'attribute' => 'type',
            'value' => $model->lookup('type'),
        ],
        'name',
        [
            'attribute' => 'status',
            'value' => $model->lookup('status'),
        ],
        [
            'attribute' => 'visible',
            'value' => $model->lookup('visible'),
        ],
        'brand_id',
        'description',
        'introduction:ntext',
        /*
        [
            'label' => '明细',
            'format' => 'raw',
            'value' => $this->render('_grid-item', ['model' => $model]),
        ],
        */
    ],
]);
