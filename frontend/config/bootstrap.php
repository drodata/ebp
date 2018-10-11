<?php
Yii::$container->set('yii\widgets\ListView', [
    'layout' => "{summary}\n{items}\n<div class=\"col-sm-12\">{pager}</div>",
    'summaryOptions' => ['class' => 'col-sm-12'],
    'emptyTextOptions' => ['class' => 'col-sm-12'],
]);
