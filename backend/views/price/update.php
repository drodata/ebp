<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Price */

use drodata\helpers\Html;
use drodata\widgets\Box;

$this->title = '修改价格';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'价格' , 'url' => ['index']],
    ],
    /*
    'alerts' => [
        [
            'options' => ['class' => 'alert-info'],
            'body' => 'hello',
            'closeButton' => false,
            'visible' => true, //Yii::$app->user->can(''),
        ], 
    ],
    */
];
?>
<div class=row "price-update">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">

        <?= $this->render('@drodata/views/_alert') ?>

        <?= Box::widget([
            'content' => $this->render('_form', [
                'model' => $model,
            ]),
        ]) ?>
    </div>
</div>
