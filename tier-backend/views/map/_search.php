<?php

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\MapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row map-search">
    <div class="col-xs-12">
        <?php Box::begin([
            'title' => '搜索',
            'style' => 'info',
            'tools' => ['collapse'],
        ]);?>
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'options' => ['class' => 'row'],
            ]); ?>
            <div class="col-xs-6">
                <?php //echo $form->field($model, 'id')->label(false)->input('number', ['placeholder' => 'ID']); ?>
            </div>
            <div class="col-xs-6">
                <?php //echo $form->field($model, 'status')->label(false)->dropDownList(Lookup::items('Status'), ['prompt' => '']); ?>
            </div>
            <div class="col-xs-12">
            <?= $form->field($model, 'id') ?>

            <?= $form->field($model, 'type') ?>

            <?= $form->field($model, 'from_id') ?>

            <?= $form->field($model, 'to_id') ?>

            <div class="form-group">
                <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('重置', "/map/index", ['class' => 'btn btn-default']) ?>
            </div>
            </div>
            <?php ActiveForm::end(); ?>
        <?php Box::end();?>
    </div>
</div>
