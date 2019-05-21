<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Price */

use drodata\helpers\Html;
use backend\models\Lookup;


$commonJs = <<<JS
JS;
$this->registerJs($commonJs);

$create = <<<JS
add_row(idx);
JS;
$update = <<<JS
JS;

if ($model->isNewRecord) {
    $this->registerJs($create);
} else {
    $this->registerJs($update);
}
?>

