<?php

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Map */
/* @var $form yii\widgets\ActiveForm */

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/
?>

<div class="map-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'prevent-duplicate-submission'],
    ]); ?>
        <!--
        <div class="row">
            <div class="col-lg-6 col-md-12">
            </div>
        </div>

        'inputTemplate' => '<div class="input-group"><div class="input-group-addon">$</div>{input}</div>'
        -->
    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '保存', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
