<?php

/* @var $this yii\web\View */
/* @var $model backend\models\PriceGroup */
/* @var $form yii\bootstrap\ActiveForm */

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Lookup;
use kartik\select2\Select2;

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/
?>

<?= $this->render('@drodata/views/_alert') ?>

<div class="price-group-form">
    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'prevent-duplicate-submission',
            // 如果表单需要上传文件，去掉下面一行的注释
            //'enctype' => 'multipart/form-data',
        ],
        // 如果表单需要通过 AJAX 提交，去掉下面两行的注释
        // 'id' => 'price-group-form',
        // 'action' => 'ajax-submit',
    ]); ?>
        <!--
        'inputTemplate' => '<div class="input-group"><div class="input-group-addon">$</div>{input}</div>'
        -->
    <?= $form->field($model, 'currency_code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'offset')->input('number', ['step' => 0.01]) ?>

    <?php if ($model->isNewRecord): ?>
    <?php endif; ?>
    <?php

    // uncomment next line when using ajax submiting
    // echo $form->field($model, 'id')->label(false)->hiddenInput();

    /**
    if ($model->isNewRecord) {
        echo $form->field($common, 'images[]')->fileInput(['multiple' => true]);
    }
    echo $this->render('_field', [
        'form' => $form,
        'model' => $model,
        'common' => $common,
    ]);
     */
    ?>
    <div class="row">
        <div class="col-lg-6 col-md-12">
        </div>
        <div class="col-lg-6 col-md-12">
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '保存', [
            'class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'),
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
