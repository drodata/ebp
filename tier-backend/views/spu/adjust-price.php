<?php

/**
 * 与 create.php 中将 _form 独立出来不同，此视图直接使用表单，用于一些简单的操作
 */

/* @var $this yii\web\View */
/* @var $model backend\models\Spu */
/* @var $prices backend\models\Price[] */

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;
use kartik\select2\Select2;

$this->title = '调整基础价格';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'产品' , 'url' => ['index']],
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
<div class="row spu-form">
    <div class="col-md-12 col-lg-6">
        <?php Box::begin([
        ]); ?>
            <?php $form = ActiveForm::begin(); ?>
            <?php foreach ($prices as $skuId => $price): ?>
                <?= $form->field($price, "[$skuId]price")->label($price->sku->name)->input('number', ['placeholder' => '输入单价']) ?>
            <?php endforeach; ?>
                <div class="form-group">
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        <?php Box::end(); ?>
        <?= $this->render('@drodata/views/_alert')  ?>
    </div>
</div>
