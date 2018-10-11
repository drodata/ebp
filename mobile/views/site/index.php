<?php
use drodata\weui\Html;

/* @var $this yii\web\View */

$this->title = '首页';
$this->params = [
    'title' => $this->title,
    'subtitle' => '基于 WeUI WeUI.js 的移动端 Web 应用',
];

$js = <<<JS
$('#submit').click(function(){
    weui.confirm('Hello WeUI js');
});
JS;
$this->registerJs($js);
?>

<div class="weui-panel">
    <div class="weui-panel__hd">图文组合列表</div>
    <div class="weui-panel__bd">
        <div class="weui-media-box weui-media-box_text">
            <h4 class="weui-media-box__title">标题一</h4>
            <p class="weui-media-box__desc">由各种物质组成的巨型球状天体，叫做星球。星球有一定的形状，有自己的运行轨道。</p>
        </div>
    </div>
    <div class="weui-media-box weui-media-box_small-appmsg">
            <div class="weui-cells">
                <a class="weui-cell weui-cell_access" href="javascript:;">
                    <div class="weui-cell__hd">
                    <?= Html::icon('user', ['style' => 'width:20px;margin-right:5px;display:block']) ?>
                    </div>
                    <div class="weui-cell__bd weui-cell_primary">
                        <p>支持 Font Awesome</p>
                    </div>
                    <span class="weui-cell__ft">More</span>
                </a>
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                    <?= Html::icon('cog', ['style' => 'width:20px;margin-right:5px;display:block']) ?>
                    </div>
                    <div class="weui-cell__bd weui-cell_primary">
                        <p>Setting</p>
                    </div>
                    <span class="weui-cell__ft">Home</span>
                </div>
            </div>
        </div>
    <div class="weui-panel__ft">
        <div class="weui-form-preview__ft">
            <a class="weui-form-preview__btn weui-form-preview__btn_default" href="javascript:">操作</a>
            <a class="weui-form-preview__btn weui-form-preview__btn_primary" href="javascript:">操作</a>
        </div>
    </div>
</div>
