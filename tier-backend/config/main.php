<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'EBP',
    'basePath' => dirname(__DIR__),
    'controllerMap' => [
        'user' => [
            'class' => 'drodata\controllers\UserController',
        ],
        'rate' => [
            'class' => 'drodata\controllers\RateController',
        ],
        'currency' => [
            'class' => 'drodata\controllers\CurrencyController',
        ],
        'spu-category' => [
            'class' => 'drodata\controllers\TaxonomyController',
            'name' => '商品分类',
        ],
        'spu-property' => [
            'class' => 'drodata\controllers\TaxonomyController',
            'name' => '商品属性',
        ],
        'spu-specification' => [
            'class' => 'drodata\controllers\TaxonomyController',
            'name' => '商品规格',
        ],
    ],
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'dashboard/index',
    'bootstrap' => ['log'],
    'components' => [
        'user' => [
            'identityClass' => 'drodata\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'rules' => [
                'demo/category/<category>' => 'demo/index',
            ],
        ],
    ],
    'params' => $params,
];
