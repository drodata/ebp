<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
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
    <div class="content">
        <div class="page__hd">
            <h1 class="page__title"><?= $this->params['title'] ?></h1>
            <p class="page__desc"><?= $this->params['subtitle'] ?></p>
        </div>
        <?= $content ?>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
