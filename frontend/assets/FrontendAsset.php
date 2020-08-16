<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main frontend application asset bundle.
 */
class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/css/perfect-scrollbar.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.css',

        // Общая таблица стилей
        'css/styles.css',
    ];

    public $cssOptions = [
        'position' => View::POS_HEAD,
    ];

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.js',
        'js/index.js'
    ];

    public $jsOptions = [
        'position' => View::POS_END,
    ];

    public $depends = [
        'frontend\assets\FontAwesomeAsset', // подключение иконок
        'frontend\assets\FontFrontendAsset', // подключение шрифтов
        'yii\web\YiiAsset',

        // прописаны новые пути для подключения библиотек для этого ассета в frontend/config/main.php
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
