<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 16/09/2019
 * Time: 09:00
 */

namespace common\components;

use Yii;


/**
 * Сервис, который управляет отправкой SMS
 *
 * Class SmsServices
 * @package common\services
 * @link    http://sms.ru/php
 */
class SmsService
{
    public static function getText($code)
    {
        return 'Ваш код подтверждения: '.$code.'. Введите его в поле ввода. Цифровой прорыв';
    }

    /**
     * @param $phone
     * @param $text string Код подтверждения
     * @return bool
     */
    public function send($phone, $text)
    {
        // Проверка: включена ли отправка SMS
        if (!Yii::$app->params['sms.canSend']) return false;

        // Проверка: заполнен ли номер
        if (empty($phone)) return false;

        $smsru = new SMSRU(Yii::$app->params['sms.SmsRuApiKey']);
        $data = new \stdClass();
        $data->to = $phone;
        $data->text = self::getText($text);
        $sms = $smsru->send_one($data);

        return $sms->status;
    }
}