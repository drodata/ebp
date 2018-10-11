<?php
use drodata\helpers\Html;
use drodata\widgets\Box;
use drodata\widgets\ChartJs;
use backend\widgets\Pie;

/* @var $this yii\web\View */

$this->title = 'Chart.js';
$this->params = [
    'title' => $this->title,
    'breadcrumbs' => [
        ['label' => 'Index', 'url' => 'index'],
        $this->title,
    ],
];

?>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <?= Box::widget([
            'title' => 'Line',
            'tools' => [
                'collapse',
            ],
            'content' => $this->render('_widget-sale-chart'),
        ]) ?>
    </div>
    <div class="col-lg-6 col-md-12">
        <?= Box::widget([
            'title' => 'Line',
            'tools' => [
                'collapse',
            ],
            'content' => $this->render('_chart-pie'),
        ]) ?>
    </div>
</div>
