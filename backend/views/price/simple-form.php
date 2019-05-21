<?php

/**
 * 与 create.php 中将 _form 独立出来不同，此视图直接使用表单，用于一些简单的操作
 */

/* @var $this yii\web\View */
/* @var $model backend\models\Price */

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;
use kartik\select2\Select2;

$this->title = '新建';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'价格' , 'url' => ['index']],
        $this->title,
    ],
    'alerts' => [
        [
            'options' => ['class' => 'alert-info'],
            'body' => '提示：',
            'closeButton' => false,
            'visible' => false, //Yii::$app->user->can(''),
        ], 
    ],
];

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/

?>
<div class="row price-form">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
    <?= $this->render('@drodata/views/_alert')  ?>
    <?php Box::begin([
        'title' => $this->title,
    ]); ?>
            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'prevent-duplicate-submission',
                    // 如果表单需要上传文件，去掉下面一行的注释
                    //'enctype' => 'multipart/form-data',
                ],
            ]); ?>
                <!--
                'inputTemplate' => '<div class="input-group"><div class="input-group-addon">$</div>{input}</div>'
                -->
                <?= $form->field($model, 'type')->radioList(Lookup::items('type')) ?>
                <div class="form-group">
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
    <?php Box::end(); ?>
    </div>
</div>
