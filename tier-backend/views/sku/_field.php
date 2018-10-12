<?php

use drodata\helpers\Html;
use drodata\widgets\Box;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model backend\models\Sku */
/* @var $common backend\models\CommonForm */
?>
<div class="row">
    <div class="col-lg-12">
        <?= $form->field($model, 'spu_id')->widget(Select2::classname(), [
        'data' => [],
        'options' => ['placeholder' => '请选择'],
        'addon' => [
            'append' => [
                'content' => Html::button(Html::icon('plus'), [
                    'class' => 'btn btn-default', 
                    'data' => [
                        'toggle' => 'tooltip',
                        'title' => '新建', 
                    ],
                ]),
                'asButton' => true
            ]
        ],
    ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-lg-12">
    </div>
</div>
