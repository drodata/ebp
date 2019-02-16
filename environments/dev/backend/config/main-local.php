<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}
if (YII_ENV_DEV) {    
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',      
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'],  
        'generators' => [
            'model' => [
                'class' => 'drodata\gii\backend\model\Generator',
                'templates' => [
                    'local' => '@drodata/gii/backend/model/default',
                ]
            ],
            // 使用 yii2-utility 中的generator, 如果想使用本地的类，记得在 entry script 内覆盖 `drodata` alias
            'crud' => [
                'class' => 'drodata\gii\backend\crud\Generator',
                'templates' => [
                    // 方便在本地调试 yii2-utility extension
                    'local' => '@drodata/gii/backend/crud/default',
                ]
            ],
            'controller' => [
                'class' => 'drodata\gii\backend\controller\Generator',
                'templates' => [
                    'local' => '@drodata/gii/backend/controller/default',
                ]
            ],
            /*
            'controller-api' => [
                'class' => 'drodata\gii\api\controller\Generator',
                'templates' => [
                    'default' => '@drodata/gii/api/controller/default',
                ]
            ],
            */
            'form' => [
                'class' => 'yii\gii\generators\form\Generator',
                'templates' => [
                    'drodata' => '@drodata/gii/backend/form/default',
                ]
            ],
        ],
    ];
}

return $config;
