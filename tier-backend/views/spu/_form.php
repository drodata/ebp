<?php

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Lookup;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Spu */
/* @var $form yii\bootstrap\ActiveForm */

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/
?>

<?= $this->render('@drodata/views/_alert') ?>

<div class="spu-form">
    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'prevent-duplicate-submission',
            // 如果表单需要上传文件，去掉下面一行的注释
            //'enctype' => 'multipart/form-data',
        ],
        // 如果表单需要通过 AJAX 提交，去掉下面两行的注释
        // 'id' => 'spu-form',
        // 'action' => 'ajax-submit',
    ]); ?>
        <!--
        'inputTemplate' => '<div class="input-group"><div class="input-group-addon">$</div>{input}</div>'
        -->
    <?= $form->field($model, 'mode')->inline()->radioList(Lookup::items('spu-mode')) ?>
    <?= $form->field($model, 'type')->inline()->radioList(Lookup::items('spu-type')) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->inline()->radioList(Lookup::items('spu-status')) ?>
    <?= $form->field($model, 'visible')->inline()->radioList(Lookup::items('boolean')) ?>
    <?= $form->field($model, 'brand_id')->widget(Select2::classname(), [
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
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'introduction')->textArea(['rows' => 3, 'placeholder' => '选填']) ?>

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
