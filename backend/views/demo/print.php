<?php
use drodata\helpers\Html;
use drodata\widgets\Box;
use drodata\jqprint\PrintAsset;
use drodata\models\Lookup;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use backend\models\CommonForm;

/* @var $this yii\web\View */

PrintAsset::register($this);

$this->title = '页面内直接打印';
$this->params = [
    'title' => $this->title,
    'breadcrumbs' => [
        $this->title,
    ],
];

$model = new CommonForm(['scenario' => CommonForm::SCENARIO_DEMO]);

$js = <<<JS
$('.print-button').click(function(){
    $('.print-container').jqprint()
})
var form = $('#print-form')
    submitBtn = form.find('[type=submit]'),

form.on('beforeSubmit', function() {
    submitBtn.prop('disabled', true)
    var data = form.serialize()
    
    $.post(form.attr('action'), form.serialize(), function(response) {
        $('.general-print-container').remove()
        $(response).appendTo('body');
        $('.general-print-container').jqprint()
    }).fail(ajax_fail_handler).always(function(){
        submitBtn.prop('disabled', false)
    });

    return false;
})
JS;
$this->registerJs($js);
?>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <?php Box::begin(['title' => '直接打印']) ?>
            <?= Html::button('打印', ['class' => 'btn btn-primary print-button']) ?>
        <?php Box::end();?>
    </div>
    <div class="col-lg-6 col-md-12">
    <?php Box::begin(['title' => 'Ajax 表单提交打印']) ?>
        <?php $form = ActiveForm::begin([
            'id' => 'print-form',
            'action' => '/demo/ajax-print',
        ]); ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <div class="form-group">
            <?= Html::submitButton('打印', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?php Box::end();?>
    </div>
</div>

<div class="print-container visible-print-block">
    <table class="table table-print table-bordered">
        <thead>
            <tr>
                <th>姓名</th>
                <th class="text-right">金额</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>测试</td>
                <td class="text-right">3300.00</td>
            </tr>
        </tbody>
    </table>

    <div class="row">
        <div class="col-xs-6">
            <h3 class="text-right text-danger">发件人信息</h3>
            <p>你好</p>
        </div>
        <div class="col-xs-6">
            <h3 class="text-right text-danger">收件人信息</h3>
            <p>你好</p>
        </div>
    </div>
</div>
