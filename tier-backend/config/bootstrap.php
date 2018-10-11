<?php
Yii::$container->set('yii\grid\GridView', [
    'options' => ['class' => 'table-responsive grid-view'],
    'tableOptions' => [
        'class' => 'table table-striped table-hover table-nowrap',
    ],
]);

Yii::$container->set('yii\widgets\ListView', [
    'layout' => "{summary}\n{items}\n<div class=\"col-sm-12\">{pager}</div>",
    'summaryOptions' => ['class' => 'col-sm-12'],
    'emptyTextOptions' => ['class' => 'col-sm-12'],
]);

/**
 * Attribute hints 改用 Bootstrap Popover 显示
 */
Yii::$container->set('yii\bootstrap\ActiveForm', [
    'fieldClass' => 'drodata\bootstrap\ActiveField',
]);
Yii::$container->set('yii\bootstrap\BootstrapAsset', [
    'cssOptions' => ['media' => 'print, screen'],
]);
Yii::$container->set('kartik\daterange\DateRangePicker', [
    'convertFormat'=>true,
    'pluginOptions'=> [
        'locale'=>[
            'format'=>'Ymd',
            'separator' => '-',
            'cancelLabel' => '重置',
        ],
    ],
    'pluginEvents'=> [
        "cancel.daterangepicker" => 'function(ev, picker) {$(this).val("").trigger("change");}',
    ],
]);
