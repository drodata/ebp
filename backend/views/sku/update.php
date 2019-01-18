<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Sku */

use drodata\helpers\Html;
use drodata\widgets\Box;

$this->title = '修改商品';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'商品' , 'url' => ['index']],
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
<div class=row "sku-update">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?= Box::widget([
            'content' => $this->render('_form', [
                'model' => $model,
            ]),
        ]) ?>
    </div>
</div>
