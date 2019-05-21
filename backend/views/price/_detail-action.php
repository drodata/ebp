<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Price */
?>

<div class="row">
    <div class="col-xs-12">
        <div class="operation-group text-right">
            <?php
            echo $model->actionLink('update', ['type' => 'button']);
            echo $model->actionLink('delete', ['type' => 'button']);
            ?>
        </div>
    </div>
</div>
