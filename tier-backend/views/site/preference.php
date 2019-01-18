<?php

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $options drodata\models\Option[] */

$this->title = '偏好设置';
$this->params = [
    'title' => $this->title,
    'breadcrumbs' => [
        ['label' => $this->title, 'url' => ['index']],
    ],
    'alerts' => [
        [
            'options' => ['class' => 'alert-info'],
            'body' => '',
            'closeButton' => false,
            'visible' => false, //Yii::$app->user->can(''),
        ], 
    ],
];
?>
<div class="row rate-create">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <div class="contact-form">
        <?php Box::begin(['title' => $this->title]); ?>
            <?php $form = ActiveForm::begin(); ?>
        
            <?php foreach ($options as $code => $option): ?>
                <h4><?= $option->directive->name ?></h4>
                <?php
                switch ($option->directive->format) {
                    case 
                }
                ?>
                <?= $form->field($option, "[$code]value")->label($option->directive->name)->textInput(['maxlength' => true]) ?>
            <?php endforeach; ?>
        
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '新建' : '保存', [
                    'class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'),
                ]) ?>
            </div>
        
            <?php ActiveForm::end(); ?>
        
        <?php Box::end(); ?>
        </div>
    </div>
</div>
