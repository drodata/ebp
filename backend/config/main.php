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
        'spu-type' => [
            'class' => 'drodata\controllers\LookupController',
            'name' => '商品分类',
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'as verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ],
        'spu-property' => [
            'class' => 'drodata\controllers\TaxonomyController',
            'modelClass' => 'backend\models\Taxonomy',
            'name' => '商品属性',
            'isLite' => true,
        ],
        'spu-specification' => [
            'class' => 'drodata\controllers\TaxonomyController',
            'modelClass' => 'backend\models\Taxonomy',
            'name' => '商品规格',
            'isLite' => true,
        ],
        'attachment' => [
            'class' => 'dro\attachment\AttachmentController',
            'modelClass' => 'backend\models\Attachment',
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
