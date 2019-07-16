<?php

/* @var $model backend\models\Sku */

use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'price.value:decimal',
        'stock:integer',
        'threshold:integer',
        'description',
        'introduction:ntext',
        /*
        [
            'attribute' => 'status',
            'value' => $model->lookup('status'),
        ],
        [
            'attribute' => 'visible',
            'value' => $model->lookup('visible'),
        ],
        [
            'label' => '明细',
            'format' => 'raw',
            'value' => $this->render('_grid-item', ['model' => $model]),
        ],
        */
    ],
]);
