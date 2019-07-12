<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SkuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/**
 * 借助 'caption' 属性显示筛选数据累计金额
if (empty(Yii::$app->request->get('SkuSearch'))) {
    $caption = '';
} else {
    $sum = (int) $dataProvider->query->sum('amount');;
    $badge = Html::tag('span', Yii::$app->formatter->asDecimal($sum), [
        'class' => 'badge',
    ]);
    $caption = Html::tag('p', "筛选累计 $badge");
}
 */
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'tableOptions' => ['class' => 'table table-condensed'],
    'columns' => [
        [
            'label' => '属性',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return implode(' ', $model->specificationNames);
            },
        ],
        [
            'label' => '单价',
            'format' => 'decimal',
            'value' => function ($model, $key, $index, $column) {
                return $model->price->value;
            },
            'headerOptions' => [
                'class' => 'text-right',
            ],
            'contentOptions' => [
                'class' => 'text-right',
            ],
        ],
        /*
        'stock',
        [
            'class' => 'drodata\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
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
        */
    ],
]); ?>
