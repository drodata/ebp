<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Price */

use yii\widgets\DetailView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;

$this->title = '商品价格详情';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'商品价格' , 'url' => ['index']],
    ],
];
?>
<div class="row price-view">
    <div class="col-sm-12 col-lg-8">
        <?php
        Box::begin([
            'title' => $this->title,
            'tools' => [],
        ]);
        echo $this->render('_detail-action', ['model' => $model]);
        echo $this->render('_detail-view', ['model' => $model]);
        Box::end();
        ?>
    </div>
</div>
