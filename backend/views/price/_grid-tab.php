<?php

/**
 * 用在首页 Tabs widget 内，用来实现“待办事项”
 */

/* @var $this yii\web\View */

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $searchModel backend\models\PriceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        'sku_id',
        'price_group_id',
        [
            'attribute' => 'threshold',
            'format' => 'integer',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
            ],
        ],
        [
            'attribute' => 'price',
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
