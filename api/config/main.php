<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'timeZone' => 'Asia/Shanghai', // timezone list: http://php.net/manual/en/timezones.php
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->isSuccessful) {
                    $response->statusCode = 200;
                }
            },
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'brand'],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'sku',
                    'ruleConfig' => [
                        'class' => 'yii\web\UrlRule',
                        'defaults' => [
                            'expand' => 'spu',
                        ]
                    ],
                ],
                /*
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'package',
                    'extraPatterns' => [
                        'GET locate' => 'locate',
                        'GET find' => 'find',
                        'GET badge' => 'badge',
                    ],
                ],
                */
            ],
        ],
    ],
    'params' => $params,
];
