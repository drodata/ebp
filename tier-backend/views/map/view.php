<?php

use yii\widgets\DetailView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Map */

$this->title = $model->id;
$this->params = [
    'title' => '详情',
    //'subtitle' => '#' . $model->id,
    'breadcrumbs' => [
        ['label' => 'Maps', 'url' => ['index']],
        $this->title,
    ],
];
?>
<div class="row map-view">
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
