<?php

use drodata\helpers\Html;
use drodata\widgets\Box;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model backend\models\Sku */
?>
<div class="row">
    <div class="col-lg-6 col-md-12">
    </div>
    <div class="col-lg-6 col-md-12">
    </div>
</div>
<?= $form->field($model, 'name')->label(false)->hiddenInput() ?>
