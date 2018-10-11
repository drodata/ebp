<?php
use drodata\helpers\Html;
use drodata\widgets\Box;
use \common\widgets\ChartJs;

/* @var $this yii\web\View */

$this->title = 'FontAwesome';
$this->params = [
    'title' => $this->title,
    'subtitle' => '常用图标速查',
    'breadcrumbs' => [
        ['label' => 'Index', 'url' => 'index'],
        $this->title,
    ],
];
$icons = [
    'sliders', 
    'toggle-on', 'toggle-off',
    'database', 'sign-in',
];
?>
<div class="row">
    <?php foreach ($icons as $icon): ?>
    <div class="col-lg-2 col-md-4 col-sm-6 h3">
        <?= Html::icon($icon) ?> 
        <?= $icon ?>
    </div>
    <?php endforeach; ?>
</div>
