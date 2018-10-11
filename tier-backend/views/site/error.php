<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use drodata\helpers\Html;
use drodata\widgets\Box;

$this->title = $name;
?>
<div class="row">
    <div class="col-lg-6 col-lg-offset-3 col-md-12">
        <?= Box::widget([
            'title' => Html::fwicon('warning') . $name,
            'style' => 'danger',
            'solid' => true,
            'content' => $exception->getMessage(),
        ]) ?>
    </div>
</div>
