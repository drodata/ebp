<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-mobile',
    'name' => 'YAT Mobile',
    'layout' => 'tabbar',
    'timeZone' => 'Australia/Sydney', // timezone list: http://php.net/manual/en/timezones.php
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'mobile\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['log'],
    'modules' => [
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
