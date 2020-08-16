<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 20:24
 */

namespace common\helpers;


class MyHelper
{
    /**
     * Удаляет все пробелы из строки
     *
     * @param $string
     * @return mixed
     */
    public static function allTrim($string)
    {
        return preg_replace('/\s+/', '', $string);
    }
}