<?php

use yii\bootstrap\Modal;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Map */

Modal::begin([
    'id' => 'view-modal',
    'header' => '详情',
    'headerOptions' => [
        'class' => 'h3 text-center',
    ],
    //'size' => Modal::SIZE_LARGE,
]);
?>

<div class="row">
    <div class="col-xs-12">
        <?php
        echo $this->render('_detail-action', ['model' => $model]);
        echo $this->render('_detail-view', ['model' => $model]);
        ?>
    </div>
</div>

<?php Modal::end(); ?>
