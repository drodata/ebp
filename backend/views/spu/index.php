<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SpuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\widgets\ListView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;
use yii\grid\GridView;


$this->title = "产品";
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => "产品", 'url' => 'index'],
        '管理',
    ],
    'buttons' => [
        Html::actionLink('/spu/create', [
            'type' => 'button',
            'title' => '新建产品',
            'icon' => 'plus',
            'color' => 'success',
            'visible' => true, //Yii::$app->user->can(''),
        ]),
        Html::actionLink('/spu/modal-search', [
            'type' => 'button',
            'title' => '高级搜索',
            'icon' => 'search',
            'color' => 'primary',
            'class' => 'modal-search',
            'visible' => false,
        ]),
    ],
    'alerts' => [
        [
            'options' => ['class' => 'alert-info'],
            'body' => 'hello',
            'closeButton' => false,
            'visible' => false, //Yii::$app->user->can(''),
        ], 
    ],
];
?>
<div class="row spu-index">
    <div class="col-xs-12">
        <?= $this->render('@drodata/views/_alert') ?>
        <?php Box::begin([
        ]);?>
             <?= $this->render('@drodata/views/_button') ?>
             <?= $this->render('_grid', [
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]) ?>
        <?php Box::end();?>
    </div>
</div> <!-- .row -->
