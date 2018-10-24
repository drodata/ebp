<?php

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Lookup;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Spu */
/* @var $form yii\bootstrap\ActiveForm */

if ($model->isNewRecord) {
    backend\assets\SpuAsset::register($this);
}
?>

<?= $this->render('@drodata/views/_alert') ?>

<div class="spu-form">
    <?php $form = ActiveForm::begin([
        'id' => 'spu-form',
        'action' => $model->isNewRecord ? 'ajax-submit' : '',
    ]); ?>
    <?= $form->field($model, 'type')->inline()->radioList(Lookup::items('spu-type')) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'brand_id')->dropDownList(Lookup::brands(), ['prompt' => '可不填']) ?>

<?php if ($model->isNewRecord): ?>
    <div class="form-group">
        <label class="control-label" for="properties">属性</label> 
        <?= Select2::widget([
            'name' => 'properties',
            'value' => $model->isNewRecord ? '' : $model->propertyNameIds,
            'data' => Lookup::properties(),
            'options' => ['class' => 'spu-property', 'placeholder' => '选填。用于创建具有多种规格的商品', 'multiple' => true],
            'addon' => [
                'append' => [
                    'content' => Html::button(Html::icon('plus'), [
                        'class' => 'btn btn-primary modal-create-taxonomy', 
                        'data' => [
                            'type' => 'spu-property',
                            'taxonomy' => [
                                'parent_id' => null,
                                'hide_parent' => 1,
                            ],
                            'toggle' => 'tooltip',
                            'title' => '新建产品属性', 
                        ],
                    ]),
                    'asButton' => true
                ]
            ],
        ]) ?>
    </div>
<?php endif; ?>

    <div class="specification-container"></div>

    <?= $form->field($model, 'id')->label(false)->hiddenInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '保存', [
            'class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'),
            'data' => [
                'properties' => Lookup::properties(),
                'specifications' => Lookup::specifications(),
                'map' => Lookup::propertyMap(),
            ],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?= $this->render('_tabular-input-template') ?>
