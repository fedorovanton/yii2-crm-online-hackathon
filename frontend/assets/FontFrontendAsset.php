<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 11:41
 */

namespace frontend\assets;


use yii\web\AssetBundle;

/**
 * Ассет для подключения шрифтов для фронтенда
 *
 * Class FontFrontendAsset
 * @package frontend\assets
 */
class FontFrontendAsset extends AssetBundle
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