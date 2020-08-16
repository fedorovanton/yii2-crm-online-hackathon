<?php
return [
    'components' => [
        'authManager'  => ['class' => 'yii\rbac\DbManager'],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=DB_NAME',
            'username' => 'DB_USER',
            'password' => 'DB_PASSWORD',
            'charset' => 'utf8',

            // Кэширование схемы БД
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
    'aliases'    => [
        '@frontendURL'  => 'http://DOMEN_RU',
        '@backendURL'  => 'http://POD_DOMEN_RU'
    ],
];
