<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Spu */
/* @var $commonForms backend\models\CommonForms */

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;
use backend\models\Taxonomy;
use kartik\select2\Select2;

backend\assets\SpuAsset::register($this);

$this->title = '调整产品规格';
$this->params = [
    'title' => $this->title,
    'subtitle' => $model->name,
    'breadcrumbs' => [
        ['label' =>'产品' , 'url' => ['index']],
        $this->title,
    ],
];
?>
<div class="row spu-form">
    <div class="col-md-12 col-lg-6">
        <?php Box::begin([
        ]); ?>
            <?php $form = ActiveForm::begin(); ?>
                <?php foreach ($commonForms as $idx => $commonForm): ?>
                    <?= $form->field($commonForm, "[$idx]specifications")
                        ->label(Taxonomy::item($idx))
                        ->widget(Select2::classname(), [
                            'data' => Lookup::specifications($idx),
                            'options' => ['placeholder' => '请选择', 'multiple' => true],
                            'addon' => [
                                'append' => [
                                    'content' => Html::button(Html::icon('plus'), [
                                        'class' => 'btn btn-primary modal-create-taxonomy', 
                                        'data' => [
                                            'toggle' => 'tooltip',
                                            'title' => "新建" . Taxonomy::item($idx),
                                            'category' => 'spuSpecification',
                                            'parent' => $idx,
                                            'is-lite' => 1,
                                        ],
                                    ]),
                                    'asButton' => true
                                ]
                            ],
                    ]) ?>
                <?php endforeach; ?>
                <div class="form-group">
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        <?php Box::end(); ?>
        <?= $this->render('@drodata/views/_alert')  ?>
    </div>
</div>
