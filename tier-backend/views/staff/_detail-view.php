<?php

/* @var $model backend\models\Staff */

use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'shop_id',
        /*
        [
            'label' => '明细',
            'format' => 'raw',
            'value' => $this->render('_grid-item', ['model' => $model]),
        ],
        */
    ],
]);
