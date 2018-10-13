<?php

/* @var $this yii\web\View */
/* @var $model backend\models\SkuSearch */
/* @var $form yii\widgets\ActiveForm */

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use backend\models\Lookup;
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <?php //echo $form->field($model, 'id')->input('number'); ?>
    </div>
    <div class="col-xs-12 col-sm-6">
        <?php //echo $form->field($model, 'status')->dropDownList(Lookup::items('Status'), ['prompt' => '']); ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?= $form->field($model, 'id') ?>

        <?= $form->field($model, 'spu_id') ?>

        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'status') ?>

        <?= $form->field($model, 'visible') ?>

        <?php // echo $form->field($model, 'stock') ?>

        <?php // echo $form->field($model, 'threshold') ?>

        <?php // echo $form->field($model, 'description') ?>

        <?php // echo $form->field($model, 'introduction') ?>

        <div class="form-group">
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('取消', "/sku/index", ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
