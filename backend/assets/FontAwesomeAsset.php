<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 11:40
 */

namespace backend\assets;


use yii\web\AssetBundle;

/**
 * Ассет для подключения иконок FontAwesome версии 5 для фронтенда
 *
 * Class FontAwesomeAsset
 * @package backend\assets
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/components/font-awesome';

    public $css = [
        'css/all.min.css',
    ];
}