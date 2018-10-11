<?php

/* @var $this \yii\web\View */
/* @var $content string */

use drodata\weui\Html;
use mobile\assets\AppAsset;

AppAsset::register($this);

// global js snippet
$host = '"' . Yii::$app->request->hostInfo . '/"';
$js = <<<JS
var APP = {"baseUrl": $host}
JS;
$this->registerJs($js, $this::POS_HEAD, 'global-js-constant');
unset($js);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> | <?= Html::encode(Yii::$app->name) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="weui-tab">
        <div class="weui-tab__panel">
            <?= $content ?>
        </div>
        <div class="weui-tabbar" style="position:fixed;">
            <?= Html::a(
                Html::icon('home', ['class' => 'weui-tabbar__icon']) 
                    . Html::tag('p', '首页', ['class' => 'weui-tabbar__label']),
                '#',
                ['class' => 'weui-tabbar__item weui-bar__item_on']
            ) ?>
            <?= Html::a(
                Html::icon('user', ['class' => 'weui-tabbar__icon']) 
                    . Html::tag('p', '我', ['class' => 'weui-tabbar__label']),
                '#',
                ['class' => 'weui-tabbar__item']
            ) ?>
        </div><!-- weui-tabbar -->
    </div><!-- weui-tab -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
