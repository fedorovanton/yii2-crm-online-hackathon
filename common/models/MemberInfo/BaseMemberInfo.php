<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 19:39
 */

namespace common\models\MemberInfo;


use common\helpers\MyHelper;
use function Complex\theta;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;


/**
 * Обертка над классом MemberInfo
 *
 * Class BaseMemberInfo
 * @package common\models\MemberInfo
 */
class BaseMemberInfo extends ModelMemberInfo
{
    /**
     * Бейдж выдан - Да
     */
    const BADGE_YES_ISSUED = 1;

    /**
     * Бейдж выдан - Нет
     */
    const BADGE_NOT_ISSUED = 0;

    /**
     * SMS-код проверен
     */
    const IS_VALID_SMS_CODE = 1;

    /**
     * SMS-код еще не проверен
     */
    const IS_NO_VALID_SMS_CODE = 0;

    /**
     * @param $token
     * @return bool
     */
    public function validToken($token)
    {
        return $this->token == $token;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     *
     */
    public function generateToken()
    {
        $this->token = \Yii::$app->security->generateRandomString(10);
    }

    /**
     * Сеттер Телефон подтвержден
     * @param $int
     */
    public function setIsValidSmsCode($int)
    {
        $this->isValidSmsCode = $int;
    }

    /**
     * Сеттер Результат SMS отправки
     * @param $sms_result
     */
    public function setSmsResult($sms_result)
    {
        $this->sms_result = $sms_result;
    }

    /**
     * Сеттер Бейдж выдан
     * @param $badge_issued
     */
    public function setBadgeIssued($badge_issued)
    {
        $this->badge_issued = $badge_issued;
    }

    /**
     * Сеттер Смс код
     * @param $sms_code
     */
    public function setSmsCode($sms_code)
    {
        $this->sms_code = $sms_code;
    }

    /**
     * @param $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @param $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @param $second_name
     */
    public function setSecondName($second_name)
    {
        if (empty($second_name)) {
            $this->second_name = null;
        } else {
            $this->second_name = $second_name;
        }

    }

    /**
     * @param $phone
     */
    public function setPhone($phone)
    {
        // Убрать все пробелы
        $phone = MyHelper::allTrim($phone);

        // Если номер телефона больше 11 символов, то обрезать только до 11 символов!
        if (strlen($phone) != 11) {
            $phone = substr($phone, 0, 11);
        }

        $this->phone = (string)$phone;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        if (empty($email)) {
            $this->email = null;
        } else {
            $this->email = $email;
        }
    }

    /**
     * Сеттер дата и время добавения записи
     */
    public function setCreated()
    {
        $this->created = date('Y-m-d H:i:s');
    }

    /**
     * Сеттер дата и время  обновления записи
     */
    public function setUpdated()
    {
        $this->updated = date('Y-m-d H:i:s');
    }

    /**
     * Сеттер ID пользователя представителя
     * @param $userID
     */
    public function setUserId($userID)
    {
        $this->user_id = $userID;
    }


    /**
     * Сеттер названия сценария MemberForm, с помощью которого создался объект участники
     * @param $scenario
     */
    public function setMemberFormScenario($scenario)
    {
        $this->member_form_scenario = $scenario;
    }

    /**
     * Генерация номера бейджа.
     * Алгоритм:
     * Берется ID записи и слева дополняется нулями до длины 4 символов.
     * Например ID=15... Номер бейджа '0015'
     * @return string
     */
    public function generateBadgeNumber()
    {
        return str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Сеттер генерации и сохранения номера бейджа
     */
    public function saveBadgeNumber()
    {
        $this->badge_number = $this->generateBadgeNumber();
        $this->setUpdated();
        $this->update(false);
    }

    /**
     * Геттер Фамилия Имя и Отчетсво
     */
    public function getFullName()
    {
        $name = $this->last_name;
        $name .= ' ' . $this->first_name;
        if (!empty($this->second_name)) {
            $name .= ' ' . $this->second_name;
        }
        return $name;
    }

    /**
     * Геттер статусов бейдж выдан или нет
     * @return array
     */
    public static function getBadgeIssuedStatusArray()
    {
        return [
            self::BADGE_NOT_ISSUED => 'Нет',
            self::BADGE_YES_ISSUED => 'Да'
        ];
    }

    /**
     * Геттер значение бейдж выдан
     */
    public function getBadgeIssuedValue()
    {
        return ArrayHelper::getValue(self::getBadgeIssuedStatusArray(), $this->badge_issued);
    }

    /**
     * Геттер Фамилия с инициалами
     */
    public function getLastNameWithInitials()
    {
        $name = $this->last_name;
        $name .= ' ' . mb_substr($this->first_name, 0, 1).'.';
        if (!empty($this->second_name)) {
            $name .= ' ' . mb_substr($this->second_name, 0, 1) .'.';
        }
        return $name;
    }

    /**
     * Геттер Номер телефона в формате +7 (XXX) XXX-XX-XX
     */
    public function getPhoneInIsoFormat()
    {
        if (!empty($this->phone)) {
            $phone = '+7 ';
            $phone .= '(' . substr($this->phone, 1, 3) . ')';
            $phone .= ' ' . substr($this->phone, 4, 3);
            $phone .= '-' . substr($this->phone, 7, 2);
            $phone .= '-' . substr($this->phone, 9, 2);
            return $phone;
        } else {
            return $this->phone;
        }
    }

    /**
     * Статус проверки анкеты - Черновик
     */
    const CHECK_STATUS_DRAFT = 1;

    /**
     * Статус проверки анкеты - Подтверждена
     */
    const CHECK_STATUS_CONFIRMED = 2;

    /**
     * Статус проверки rejected - Отклонена
     */
    const CHECK_STATUS_REJECTED = 3;

    /**
     * Гететр массив статусов проверки анкет
     * @return array
     */
    public static function getCheckStatusArray()
    {
        return [
            self::CHECK_STATUS_DRAFT => 'Черновик',
            self::CHECK_STATUS_CONFIRMED => 'Подтверждена',
            self::CHECK_STATUS_REJECTED => 'Отклонена',
        ];
    }

    /**
     * Геттер значения статус проверки анкеты
     * @return mixed
     */
    public function getCheckStatusValue()
    {
        if (empty($this->check_status)) return 'Черновик';

        return ArrayHelper::getValue(self::getCheckStatusArray(), $this->check_status);
    }

    /**
     * Сеттер статус проверки анкеты
     * @param $check_status
     */
    public function setCheckStatus($check_status)
    {
        $check_status = (empty($check_status)) ? self::CHECK_STATUS_DRAFT : $check_status;
        $this->check_status = $check_status;
    }
}