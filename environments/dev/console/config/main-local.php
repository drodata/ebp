<?php
return [
    'bootstrap' => ['gii'],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            // 使用 drodata/yii2-utility 中的模板文件
            'templateFile' => '@drodata/views/migration.php',
        ],
    ],
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
];
