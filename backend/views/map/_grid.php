<?php

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    /* `afterRow` has the same signature
    'rowOptions' => function ($model, $key, $index, $grid) {
        return [
            'class' => ($model->status == Product::DISABLED) ? 'bg-danger' : '',
        ];
    },
    */
    'filterModel' => $searchModel,
    'columns' => [
        // ['class' => 'yii\grid\SerialColumn'],
        'id',
        'type',
        'from_id',
        'to_id',
        /*
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
            'contentOptions' => ['style' => 'width:150px'],
            'filter' => Lookup::dateRangeFilter($searchModel, 'created_at'),
        ],
        [
            'attribute' => 'amount',
            'format' => 'decimal',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right text-bold',
                'style' => 'width:80px',
            ],
        ],
        [
            'attribute' => 'status',
            'filter' => Lookup::items('UserStatus'),
            'value' => function ($model, $key, $index, $column) {
                return Lookup::item('UserStatus', $model->status);
            },
            'contentOptions' => ['style' => 'width:80px'],
        ],
        [
            'label' => '',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model->rolesString;
            },
        ],
        */
        [
            'class' => 'drodata\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'contentOptions' => [
                'style' => 'min-width:120px',
                'class' => 'text-center',
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
