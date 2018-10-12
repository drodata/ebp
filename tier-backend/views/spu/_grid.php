<?php

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SpuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/**
 * 借助 'caption' 属性显示筛选数据累计金额
if (empty(Yii::$app->request->get('SpuSearch'))) {
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
    // 'caption' => $caption,
    'filterModel' => $searchModel,
    'columns' => [
        // ['class' => 'yii\grid\SerialColumn'],
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
    ],
]); ?>
