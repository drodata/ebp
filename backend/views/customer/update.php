<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Customer */

use drodata\helpers\Html;
use drodata\widgets\Box;

$this->title = '修改客户';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'客户' , 'url' => ['index']],
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
<div class=row "customer-update">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?= Box::widget([
            'content' => $this->render('_form', [
                'model' => $model,
            ]),
        ]) ?>
    </div>
</div>
