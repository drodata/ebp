<?php

/* @var $model backend\models\Customer */

use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        [
            'label' => '联系方式',
            'format' => 'raw',
            'value' => $this->render('@drodata/views/contact/_list', ['dataProvider' => $model->contactsDataProvider]),
        ],
    ],
]);
