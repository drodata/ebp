<?php

/**
 * 用在首页 Tabs widget 内，用来实现“待办事项”
 */

/* @var $this yii\web\View */

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $searchModel backend\models\PriceGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        'id',
        'currency_code',
        'name',
        [
            'attribute' => 'is_base',
            'filter' => Lookup::items('price-group-is-base'),
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model->lookup('is_base');
            },
        ],
        [
            'attribute' => 'offset',
            'format' => 'decimal',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
            ],
        ],
        [
            'class' => 'drodata\grid\ActionColumn',
            'template' => '{view}',
            'contentOptions' => [
                'style' => 'min-width:120px',
            ],
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return $model->actionLink('view');
                },
            ],
        ],
    ],
]); ?>
