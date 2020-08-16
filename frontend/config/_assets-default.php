<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 11:38
 */

/**
 * Переинициализированные ассеты
 */

return [
    'yii\web\JqueryAsset' => [
        'sourcePath' => '@bower/jquery/dist',
        'js' => [
            'jquery.js',
        ],
    ],
    'yii\bootstrap\BootstrapAsset' => [
        'sourcePath' => '@vendor/twbs/bootstrap/dist',
        'css' => [
            'css/bootstrap.css',
        ],
    ],
    'yii\bootstrap\BootstrapPluginAsset' => [
        'basePath' => '@webroot',
        'baseUrl' => '@web',
        'js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
            'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',
        ],
    ]
];