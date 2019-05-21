<?php

/* @var $model backend\models\Price */

use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'sku_id',
        'value:decimal',
        /*
        [
            'label' => '明细',
            'format' => 'raw',
            'value' => $this->render('_grid-item', ['model' => $model]),
        ],
        */
    ],
]);
