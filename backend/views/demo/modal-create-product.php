<?php

/**
 */

/* @var $this yii\web\View */
/* @var $model backend\models\Map */

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\widgets\Box;
use kartik\select2\Select2;
use backend\models\Lookup;

$this->title = '新建临时商品';
$this->params = [
    'title' => $this->title,
    'breadcrumbs' => [
        ['label' => '临时商品', 'url' => 'manage-product'],
        $this->title,
    ],
    'buttons' => [
        Html::actionLink('#', [
            'class' => 'modal-create-lookup',
            'type' => 'button',
            'title' => 'Modal 新建(新建后不做任何操作)',
            'color' => 'primary',
            'data' => [
                'type' => 'DemoProduct',
                'scenario' => 'default',
            ],
        ]),
    ],
    'alerts' => [
        [
            'options' => ['class' => 'alert-info'],
            'body' => '本页面演示了如何在页面不跳转的情况下，动态新增一条 Lookup 记录。',
        ],
    ],
];

?>
<div class="row acceptance-form">
    <div class="col-md-12 col-lg-4 col-lg-offset-4">
        <?php Box::begin([
        ]); ?>
            <?= $this->render('@drodata/views/_button') ?>
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'from_id')->label('临时商品')->widget(Select2::classname(), [
                    'data' => Lookup::items('DemoProduct'),
                    'options' => ['placeholder' => '请选择'],
                    'addon' => [
                        'append' => [
                            'content' => Html::button(Html::icon('plus'), [
                                'class' => 'btn btn-primary modal-create-lookup', 
                                'title' => '新增临时商品', 
                                'data' => [
                                    'type' => 'DemoProduct',
                                    'scenario' => 'dropDown',
                                ],
                            ]),
                            'asButton' => true
                        ]
                    ],
                ]) ?>
            <?php ActiveForm::end(); ?>
        <?php Box::end(); ?>
    </div>
</div>
