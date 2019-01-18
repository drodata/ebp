<?php

use yii\widgets\ListView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Maps';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => $this->title, 'url' => 'index'],
        '管理',
    ],
    'buttons' => [
        Html::actionLink('/map/create', [
            'type' => 'button',
            'title' => '新建',
            'icon' => 'plus',
            'color' => 'success',
        ]),
    ],
];

?>
<div class="row map-index">
        <div class="col-xs-12">
        <?php Box::begin([
        ]);?>
             <?= $this->render('_button') ?>
             <?= $this->render('_grid', [
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]) ?>
        <?php Box::end();?>
    </div>
    
</div> <!-- .row -->
