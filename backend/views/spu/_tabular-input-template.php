<?php

/**
 * AJAX tabular input template
 */
use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use backend\models\Lookup;
use backend\models\CommonForm;
use kartik\select2\Select2;

$item = new CommonForm();
$indexToken = 'indextoken';
$js = <<<JS
$('form#dummy-form').remove();
JS;
$this->registerJs($js);

$btn = Html::button(Html::icon('plus'), [
    'class' => 'btn btn-default modal-create-taxonomy', 
    'data' => [
        'type' => 'spu-specification',
        'taxonomy' => [
            'parent_id' => 'PARENT',
            'hide_parent' => 1,
        ],
        'toggle' => 'tooltip',
        'title' => '新建', 
    ],
]);
$template = <<<TPL
{label}
<div class="input-group">
    {input}
    <div class="input-group-btn"> 
    $btn
    </div>
</div>
{hint}
{error}
TPL;
?>
<?php $form = ActiveForm::begin(['id' => 'dummy-form']); ?>
<?php $form = ActiveForm::end(); ?>

<div class="hide">
    <div class="spu-specification-tpl">
        <?= $form->field($item, "[$indexToken]specifications", [
            'template' => $template,
        ])->label("LABEL")->dropDownList([], [
            'class' => 'spu-specification',
            'placeholder' => '请选择LABEL',
            'multiple' => true
        ]) ?>
    </div>
</div>
