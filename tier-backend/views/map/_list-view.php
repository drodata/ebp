<?php

use yii\widgets\DetailView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Map */

Box::begin([
    'title' => 'Detail',
    'footer' => $this->render('_list-action', ['model' => $model]),
]);

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        /*
        [
            'label' => '',
            'value' => $model->id,
        ],
        [
            'attribute' => 'amount',
            'format' => 'decimal',
            'contentOptions' => ['class' => 'text-right'],
            'captionOptions' => [
                'class' => 'text-right text-bold',
            ],
        ],
        */
        'id',
        'type',
        'from_id',
        'to_id',
    ],
]);

Box::end();
