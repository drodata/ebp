<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\widgets\ListView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;
use yii\grid\GridView;


$this->title = "员工";
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => "员工", 'url' => 'index'],
        '管理',
    ],
    'buttons' => [
        Html::actionLink('/staff/create', [
            'type' => 'button',
            'title' => '新建员工',
            'icon' => 'plus',
            'color' => 'success',
            'visible' => true, //Yii::$app->user->can(''),
        ]),
        Html::actionLink('/staff/modal-search', [
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
<div class="row staff-index">
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
