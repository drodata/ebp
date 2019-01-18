<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);

// global js snippet
$host = '"' . Yii::$app->request->hostInfo . '/"';
$js = <<<JS
var APP = {
	"baseUrl": $host
};
JS;
$this->registerJs($js, $this::POS_HEAD, 'global-js-constant');
unset($js);

$js = <<<JS
$('[data-toggle="popover"]').popover()
$('a:not([data-toggle])').tooltip()
$(".navbar-collapse").css({
    maxHeight: $(window).height() - $(".navbar-header").height() + "px" 
});
JS;
$this->registerJs($js);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> | <?= Yii::$app->name ?></title>
    <?php $this->head() ?>
</head>
<body class="skin-<?= Yii::$app->params['skin'] ?> layout-top-nav fixed">
<?php $this->beginBody() ?>

<div class="wrap">
    <?= $this->render('_header') ?>
    <div class="content-wrapper">
        <div class="container">
            <section class="content-header">
                <h1><?= $this->params['title'] ?><small><?= $this->params['subtitle'] ?></small> </h1>
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </section>
            <section class="content">
                <?= Alert::widget() ?>
                <?= $this->render('@drodata/views/_alert') ?>
                <?= $content ?>
            </section>
        </div>
    </div>
</div>
<footer class="main-footer">
    <div class="container">
        <div class="pull-right hidden-xs">
            <?= Yii::powered() ?>
        </div>
        <strong>&copy; <?= Html::a(Yii::$app->name, Yii::getAlias('@frontendweb')) ?> <?= date('Y') ?></strong> All rights reserved.
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
