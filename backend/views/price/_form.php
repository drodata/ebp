<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Price */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $items Price[]  */

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Lookup;
use kartik\select2\Select2;
?>

<?= $this->render('_uex', ['model' => $model]) ?>

<div class="price-form">
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
    <?= $this->render('_tabular-input', [
        'form' => $form,
        'items' => $items,
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '保存', [
            'class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'),
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
