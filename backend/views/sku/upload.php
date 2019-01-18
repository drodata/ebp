<?php

/**
 * 单独上传文件视图
 */

/* @var $this yii\web\View */
/* @var $model backend\models\Sku */

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

$this->title = '上传附件';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'商品' , 'url' => ['index']],
        $this->title,
    ],
    /*
    'alerts' => [
        [
            'options' => ['class' => 'alert-info'],
            'body' => 'hello',
            'closeButton' => false,
            'visible' => true, //Yii::$app->user->can(''),
        ], 
    ],
    */
];

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/

?>
<div class="row sku-upload-form">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?php Box::begin([
        ]); ?>
            <?= $this->render('@drodata/views/_alert') ?>

            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>
                <?= $form->field($common, 'images[]')->fileInput(['multiple' => true]) ?>
                <div class="form-group">
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        <?php Box::end(); ?>
    </div>
</div>
