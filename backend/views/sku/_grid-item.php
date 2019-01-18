<?php

/**
 * 不带分页的 grid 模板，常用显示子条目，例如一个订单所有订货明细
 * 与 _grid 的区别有: 
 * - dataProvider 直接通过模型的 getter (如 getItemsDataProvider()) 获取，不使用 SearchModel
 * - 用到 `footer` 显示累加金额
 * - 不使用 filter
 */

/* @var $this yii\web\View */
/* @var $model backend\models\Sku */

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;
use backend\models\Sku;

echo GridView::widget([
    'dataProvider' => $model->itemsDataProvider,
    'showFooter' => !empty($model->itemsDataProvider->models),
    'tableOptions' => ['class' => 'table table-condenced table-striped'],
    'summary' => '',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'spu_id',
        'name',
        'status',
        'visible',
        [
            'attribute' => 'stock',
            'format' => 'integer',
            'footer' => '', // 自行在模型中声明方法计算总数 $model->totalQuantity,
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
            ],
            'footerOptions' => ['class' => 'text-right text-bold'],
        ],
        [
            'attribute' => 'threshold',
            'format' => 'integer',
            'footer' => '', // 自行在模型中声明方法计算总数 $model->totalQuantity,
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
            ],
            'footerOptions' => ['class' => 'text-right text-bold'],
        ],
        'description',
        'introduction',
    ],
]); ?>
