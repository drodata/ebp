<?php

/* action buttons in detail view on Mobile */

/* @var $this yii\web\View */
/* @var $model backend\models\Map */
?>

<div class="row">
    <div class="col-xs-12">
        <div class="operation-group text-right">
            <?php
            echo $model->actionLink('update', 'button');
            echo $model->actionLink('delete', 'button');
            ?>
        </div>
    </div>
</div>
