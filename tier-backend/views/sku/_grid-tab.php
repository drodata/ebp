<?php

/**
 * 用在首页 Tabs widget 内，用来实现“待办事项”
 */
use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SkuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        'id',
        'spu_id',
        'name',
        [
            'attribute' => 'status',
            'filter' => Lookup::items('sku-status'),
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model->lookup('status');
            },
        ],
        [
            'attribute' => 'visible',
            'filter' => Lookup::items('boolean'),
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model->lookup('visible');
            },
        ],
        [
            'attribute' => 'stock',
            'format' => 'integer',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
            ],
        ],
        [
            'attribute' => 'threshold',
            'format' => 'integer',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
            ],
        ],
        'description',
        'introduction',
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
