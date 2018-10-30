<?php
$sensitive = json_decode(file_get_contents(Yii::getAlias('@common') . '/yii2-sensitive.json'));
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai', // timezone list: http://php.net/manual/en/timezones.php
    'aliases' => [
        '@staticweb'  => 'http://static.' . $sensitive->domain,
        '@siteweb'  => 'http://www.' . $sensitive->domain,
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
			'enableStrictParsing' => false,
            'rules' => [
            ],
        ],
        'formatter' => [
            'dateFormat' => 'php:Y-m-d',
            'timeFormat' => 'H:i',
            'datetimeFormat' => 'php:Y-m-d H:i',
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
            'defaultTimeZone' => 'Asia/Shanghai',
       ],
       'authManager' => [
           'class' => 'yii\rbac\DbManager', 
       ],
    ],
];
