<?php
/**
 * detail view on non-mobile device
 */

use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $model backend\models\Sku */

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'spu_id',
        'name',
        [
            'attribute' => 'status',
            'value' => $model->lookup('status'),
        ],
        [
            'attribute' => 'visible',
            'value' => $model->lookup('visible'),
        ],
        'stock:integer',
        'threshold:integer',
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
