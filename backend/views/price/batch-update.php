<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Price */
/* @var $items Price[]  */

use drodata\helpers\Html;
use drodata\widgets\Box;

$this->title = '设置商品价格';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'价格' , 'url' => ['index']],
        '新建',
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
<div class="row price-create">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">

        <?= $this->render('@drodata/views/_alert') ?>

        <?= Box::widget([
            'title' => $this->title,
            'content' => $this->render('_form', [
                'items' => $items,
            ]),
        ]) ?>
    </div>
</div>
