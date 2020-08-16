<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 11:41
 */

namespace backend\assets;


use yii\web\AssetBundle;

/**
 * Ассет для подключения шрифтов для фронтенда
 *
 * Class FontFrontendAsset
 * @package backend\assets
 */
class FontBackendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/fonts.css',
    ];

    public $cssOptions = [
        'rel' => 'stylesheet',
    ];
}