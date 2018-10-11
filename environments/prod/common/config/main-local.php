<?php
$sensitive = json_decode(file_get_contents(Yii::getAlias('@common') . '/yii2-sensitive.json'));
return [
    'aliases' => [
        '@frontendweb'  => 'http://www.' . $sensitive->domain,
        '@backendweb'  => 'http://backend.' . $sensitive->domain,
        '@mobileweb'  => 'http://m.' . $sensitive->domain,
        '@staticweb'  => 'http://static.' . $sensitive->domain,
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => "mysql:host=localhost;dbname={$sensitive->dbname}",
            'username' => 'root',
            'password' => $sensitive->password,
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityCookie' => [
                'name' => '_identity',
                'domain'   => '.' . $sensitive->domain,
                'httpOnly' => true,
            ],
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'cookieParams' => [
                'domain'   => '.' . $sensitive->domain,
                'httpOnly' => true,
            ],
        ],
    ],
];
