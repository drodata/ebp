<?php
use drodata\helpers\Html;
use drodata\widgets\Box;
use drodata\adminlte\Tabs;

/* @var $this yii\web\View */

$this->title = 'AdminLTE Tabs';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => 'Index', 'url' => 'index'],
        $this->title,
    ],
];

?>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <?= Tabs::widget([
                'items' => [
                    [
                        'label' => 'Unpaid',
                        'encode' => false,
                        'content' => '关键是使用<code>.nav-tabs-custom</code> 将 Bootstrap Tabs 包裹起来。',
                        'active' => true,
                    ],
                    [
                        'label' => 'Ready',
                        'encode' => false,
                        'content' => 'I am ready',
                    ],
                    [
                        'label' => Html::icon('cog'),
                        'encode' => false,
                        'headerOptions' => ['class' => 'pull-right'],
                        'linkOptions' => ['class' => 'text-muted'],
                    ],
                ],
            ]) ?>
    </div>
    <div class="col-md-6 col-sm-12">
            <?= Tabs::widget([
                'options' => ['class' => 'pull-right'],
                'items' => [
                    [
                        'label' => Html::icon('file') . 'Todos',
                        'toggleTab' => false,
                        'encode' => false,
                        'headerOptions' => ['class' => 'pull-left header'],
                    ],
                    [
                        'label' => 'Unpaid',
                        'encode' => false,
                        'content' => 'Hello',
                        'headerOptions' => ['class' => 'pull-right'],
                    ],
                    [
                        'label' => 'Ready',
                        'encode' => false,
                        'content' => 'I am ready',
                        'active' => true,
                        'headerOptions' => ['class' => 'pull-right'],
                    ],
                ],
            ]) ?>
    </div>
    <div class="col-md-6 col-sm-12">
            <?= Tabs::widget([
                'options' => ['class' => 'pull-right'],
                'items' => [
                    [
                        'label' => Html::icon('user') . 'Active via Query String',
                        'toggleTab' => false,
                        'encode' => false,
                        'headerOptions' => ['class' => 'pull-left header'],
                    ],
                    [
                        'label' => 'Unpaid',
                        'encode' => false,
                        'content' => 'Hello',
                        'options' => ['id' => 'unpaid'],
                        'headerOptions' => ['class' => 'pull-right'],
                        'active' => $_GET['tab'] == 'unpaid' ? true : false,
                    ],
                    [
                        'label' => 'Ready',
                        'encode' => false,
                        'content' => 'I am ready',
                        'options' => ['id' => 'ready'],
                        'active' => $_GET['tab'] == 'ready' ? true : false,
                        'headerOptions' => ['class' => 'pull-right'],
                    ],
                    [
                        'label' => 'Default',
                        'content' => 'Click' . Html::a('/demo/tabs?tab=unpaid', ['/demo/tabs', 'tab' => 'unpaid']),
                        'options' => ['id' => 'default'],
                        'headerOptions' => ['class' => 'pull-right'],
                        'active' => empty($_GET['tab']) ? true : false,
                    ],
                ],
            ]) ?>
    </div>
</div>
