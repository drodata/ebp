<?php

/**
 * 用在首页 Tabs widget 内，用来实现“待办事项”
 */
use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SpuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        'id',
        [
            'attribute' => 'mode',
            'filter' => Lookup::items('spu-mode'),
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model->lookup('mode');
            },
        ],
        [
            'attribute' => 'type',
            'filter' => Lookup::items('spu-type'),
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model->lookup('type');
            },
        ],
        'name',
        [
            'attribute' => 'status',
            'filter' => Lookup::items('spu-status'),
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
        'brand_id',
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
