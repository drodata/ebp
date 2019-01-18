<?php
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use backend\models\Lookup;
use kartik\select2\Select2;

$model = new Lookup();
?>

<?php Modal::begin([
    'header' => '通过 AJAX 显示 Select2 widget',
    'options' => ['id' => 'select2-modal'],
    'size' => Modal::SIZE_SMALL,
    'clientOptions' => [
        'backdrop' => 'static',
    ],
]); ?>
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'visible')->widget(Select2::classname(), [
            'data' => Lookup::items('UserStatus'),
            'options' => ['placeholder' => '请选择'],
        ]) ?>
    <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>
