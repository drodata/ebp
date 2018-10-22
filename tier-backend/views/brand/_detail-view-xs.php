<?php

/* @var $model backend\models\Brand */

use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'alias',
        [
            'attribute' => 'visible',
            'value' => $model->lookup('visible'),
        ],
        /*
        [
            'label' => '明细',
            'format' => 'raw',
            'value' => $this->render('_grid-item', ['model' => $model]),
        ],
        */
    ],
]);
