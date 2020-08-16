<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 12:15
 */

namespace console\traits;


/**
 * Конфигуратор для таблиц БД.
 *
 * @link    http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
 * @package console\traits
 */
trait DbTableConfigurator
{
    /**
     * Определение настроек таблицы.
     *
     * @param string $driverName Наименование драйвера БД.
     *
     * @return null|string
     */
    private function getOptions($driverName)
    {
        return $driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' : null;
    }
}