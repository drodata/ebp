<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PriceGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        // ['class' => 'yii\grid\SerialColumn'],
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
            'attribute' => 'discount',
            'format' => 'decimal',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
            ],
        ],
        [
            'class' => 'drodata\grid\ActionColumn',
            'template' => '{update} {delete}',
            'contentOptions' => [
                'style' => 'min-width:120px',
            ],
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return $model->actionLink('view');
                },
                'update' => function ($url, $model, $key) {
                    return $model->actionLink('update');
                },
                'delete' => function ($url, $model, $key) {
                    return $model->actionLink('delete');
                },
            ],
        ],
    ],
]); ?>
