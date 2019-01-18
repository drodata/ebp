<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model backend\models\CommonForm */

use drodata\helpers\Html;
?>
<div class="row">
    <div class="col-lg-12">
        <?= $form->field($model, 'roles')->inline()->checkboxList($model->getRolesList()) ?>
    </div>
</div>
