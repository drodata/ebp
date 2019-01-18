<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_list-item',
    'options' => ['class' => 'row'],
    'itemOptions' => ['class' => 'col-sm-12 col-md-6 col-lg-4'],
    'summary' => '',
    'summaryOptions' => ['class' => 'col-xs-12'],
    'emptyTextOptions' => ['class' => 'col-xs-12'],
    'layout' => "{summary}\n{items}\n<div class=\"col-xs-12\">{pager}</div>",
]) ?>
