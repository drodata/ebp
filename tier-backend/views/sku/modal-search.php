<?php

use yii\bootstrap\Modal;
use drodata\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Sku */

Modal::begin([
    'id' => 'search-modal',
    'header' => '高级搜索',
    'headerOptions' => [
        'class' => 'h3 text-center',
    ],
]);
?>

<div class="row">
    <div class="col-xs-12">
        <?= $this->render('_search', ['model' => $model]) ?>
    </div>
</div>

<?php Modal::end(); ?>
