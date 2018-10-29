<?php

/* @var $model backend\models\PriceGroup */

use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'currency_code',
        'name',
        [
            'attribute' => 'is_base',
            'value' => $model->lookup('is_base'),
        ],
        'offset:decimal',
        /*
        [
            'label' => '明细',
            'format' => 'raw',
            'value' => $this->render('_grid-item', ['model' => $model]),
        ],
        */
    ],
]);
