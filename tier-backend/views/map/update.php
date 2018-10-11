<?php

use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $model backend\models\Map */

$this->title = '修改Map: ' . $model->id;
$this->params = [
    'title' => '修改',
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => 'Maps', 'url' => ['index']],
        ['label' => $model->id, 'url' => ['view', 'id' => $model->id]],
    ],
];
?>
<div class=row "map-update">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?= Box::widget([
            'content' => $this->render('_form', [
                'model' => $model,
            ]),
        ]) ?>
    </div>
</div>
