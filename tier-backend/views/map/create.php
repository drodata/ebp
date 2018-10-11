<?php

use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $model backend\models\Map */

$this->title = '新建';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => 'Maps', 'url' => ['index']],
        $this->title,
    ],
];
?>
<div class="row map-create">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?= Box::widget([
            'content' => $this->render('_form', [
                'model' => $model,
            ]),
        ]) ?>
    </div>
</div>
