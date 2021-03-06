<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model backend\models\Brand */
/* @var $common backend\models\CommonForm */

use drodata\helpers\Html;
use drodata\widgets\Box;
use kartik\select2\Select2;
?>
<div class="row">
    <div class="col-lg-12">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-lg-12">
    </div>
</div>
