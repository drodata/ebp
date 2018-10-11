<?php
use yii\web\JsExpression;
use drodata\helpers\Html;
use kartik\select2\Select2;

// when user select a product
$format = <<<SCRIPT
// product selector handler
function selectSku(e) {
    // fetch item data and reset product selector
    var selector = $('#sku-selecter')
    var activeItem = e.params.data
    selector.select2('val', '')
    selector.select2('open');

    selector.trigger('selected.sku', activeItem)
}
SCRIPT;
$this->registerJs($format);
?>

<div class="form-group">
    <label class="control-label" for="sku_selecter">产品选择器</label> 
    <?= Select2::widget([
        'name' => 'sku_selecter',
        'options' => ['id' => 'sku-selecter', 'placeholder' => '选填。用于创建具有多种规格的商品'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 2,
            'ajax' => [
                'url' => \yii\helpers\Url::to(['/demo/search']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {keyword:params.term}; }')
            ],
            'language' => [
                'errorLoading' => new JsExpression("function () { return '查询中……'; }"),
                'noResults' => new JsExpression("function () { return '没有符合条件的记录'; }"),
                'inputTooShort' => new JsExpression("function () { return '输入关键字搜索（至少 2 个字符, 多个关键字用空格隔开）'; }"),
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function format(item) { return item.name; }'),
            'templateSelection' => new JsExpression('function format(item) { return item.name; }'),
        ],
        'pluginEvents' => [
            "select2:select" => "selectSku",
        ],
        'addon' => [
        ],
    ]) ?>
</div>
