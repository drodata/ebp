<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Customer */
/* @var $form yii\bootstrap\ActiveForm */

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Lookup;
use kartik\select2\Select2;
/*
$js = <<<JS
JS;
$this->registerJs($js);
*/
?>

<?= $this->render('@drodata/views/_alert') ?>

<div class="customer-form">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'prevent-duplicate-submission'],
    ]); ?>
    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'username')->textInput(['autoFocus' => true]) ?>
    <?php else: ?>
        <?= $form->field($model, 'name')->textInput(['autoFocus' => true]) ?>
    <?php endif; ?>
    <?= $this->render('@drodata/views/contact/_field', [
        'form' => $form,
        'model' => $contact,
    ]) ?>
    <?php if ($model->isNewRecord): ?>
    <?php endif; ?>
    <?php

    /**
    if ($model->isNewRecord) {
        echo $form->field($common, 'images[]')->fileInput(['multiple' => true]);
    }
    echo $this->render('_field', [
        'form' => $form,
        'model' => $model,
        'common' => $common,
    ]);
     */
    ?>
    <div class="row">
        <div class="col-lg-6 col-md-12">
        </div>
        <div class="col-lg-6 col-md-12">
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '保存', [
            'class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'),
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
