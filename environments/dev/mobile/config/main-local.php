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
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'drodata' => '@drodata/gii/backend/crud/default',
                ]
            ],
            'model' => [
                'class' => 'yii\gii\generators\model\Generator',
                'templates' => [
                    'drodata' => '@drodata/gii/backend/model/default',
                ]
            ],
            'controller' => [
                'class' => 'yii\gii\generators\controller\Generator',
                'templates' => [
                    'drodata' => '@drodata/gii/backend/controller/default',
                ]
            ],
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
