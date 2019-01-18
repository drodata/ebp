<?php

use yii\web\JsExpression;
use drodata\widgets\ChartJs;

echo ChartJs::widget([
    'type' => 'pie', // 'doughnut'
    'options' => [
        'width' => 200,
    ],
    'data' => [
        'labels' => ['Android', 'iOS'],
        'datasets' => [
            [
                'data' => [8, 2],
                'backgroundColor' => ['#24b', 'red'],
                'borderColor' => ['green', 'red'],
            ]
        ],
    ],
    'clientOptions' => [
        'title' => [
            'display' => true,
            'text' => 'Mobile OS',
        ],
        'tooltips' => [
            'callbacks' => [
                'label' => new JsExpression("function(tooltipItem, data) {
                    var amount = data.datasets[ tooltipItem.datasetIndex ].data[ tooltipItem.index ]
                        , label = data.labels[ tooltipItem.index ]
    
                    return label + ': ' + amount + 'kg'
                }"),
            ],
        ],
    ],
]);
