<?php
use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $model backend\models\Map */

?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'from_id',
            'to_id',
            /*
            [
                'attribute' => 'amount',
                'format' => 'decimal',
                'contentOptions' => ['class' => 'text-right'],
                'captionOptions' => [
                    'class' => 'text-right text-bold',
                ],
            ],
            */
        ],
    ]) ?>
