<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SpuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

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
        [
            'attribute' => 'mode',
            'filter' => Lookup::items('spu-mode'),
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model->lookup('mode');
            },
            'contentOptions' => [
                'style' => 'vertical-align:middle;',
            ],
        ],
        [
            'attribute' => 'type',
            'filter' => Lookup::items('spu-type'),
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model->lookup('type');
            },
            'contentOptions' => [
                'style' => 'vertical-align:middle;',
            ],
        ],
        [
            'attribute' => 'name',
            'contentOptions' => [
                'style' => 'vertical-align:middle;',
            ],
        ],
        [
            'attribute' => 'visible',
            'filter' => Lookup::items('boolean'),
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model->lookup('visible');
            },
            'contentOptions' => [
                'style' => 'vertical-align:middle;',
            ],
        ],
        [
            'attribute' => 'brand_id',
            'filter' => Lookup::brands(),
            'value' => function ($model, $key, $index, $column) {
                return $model->brand->name;
            },
            'contentOptions' => [
                'style' => 'vertical-align:middle;',
            ],
        ],
        [
            'label' => '属性',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $this->render('/sku/_grid-in-spu', ['dataProvider' => $model->skusDataProvider]);
            },
        ],
        [
            'class' => 'drodata\grid\ActionColumn',
            'template' => '{view} {update} {upload-image} {adjust-price} {adjust-specification} {delete}',
            'contentOptions' => [
                'class' => 'text-center',
                'style' => 'min-width:120px;vertical-align:middle;',
            ],
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return $model->actionLink('view');
                },
                'update' => function ($url, $model, $key) {
                    return $model->actionLink('update');
                },
                'adjust-price' => function ($url, $model, $key) {
                    return $model->actionLink('adjust-price');
                },
                'upload-image' => function ($url, $model, $key) {
                    return $model->actionLink('upload-image');
                },
                'adjust-specification' => function ($url, $model, $key) {
                    return $model->actionLink('adjust-specification');
                },
                'delete' => function ($url, $model, $key) {
                    return $model->actionLink('delete');
                },
            ],
        ],
    ],
]); ?>
