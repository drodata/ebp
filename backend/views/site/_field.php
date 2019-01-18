<?php

use drodata\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model drodata\models\Contact */
?>
<div class="row">
    <div class="col-lg-6 col-lg-12">
        <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'maxlength' => true]) ?>
    </div>
    <div class="col-lg-6 col-lg-12">
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?= $form->field($model, 'address')->textArea(['rows' => 3]) ?>
    </div>
</div>
