<?php

namespace common\models\MemberInfo;

use Yii;

/**
 * This is the model class for table "member_info".
 *
 * @property int $id
 * @property string $first_name Имя
 * @property string $last_name Фамилия
 * @property string $second_name Отчество
 * @property string $phone Телефон
 * @property string $email Email
 * @property string $sms_code SMS-код
 * @property string $isValidSmsCode Телефон подтвержден
 * @property string $badge_number Номер бейджа
 * @property string $token Токен
 * @property string $sms_result Токен
 * @property string $member_form_scenario Токен
 * @property integer $user_id ID пользователя представителя
 * @property integer $check_status Статус проверки анкеты
 * @property integer $badge_issued Бейдж выдан
 * @property string $created Дата и время добавления
 * @property string $updated Дата и время обновления
 */
class ModelMemberInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['created', 'updated'], 'safe'],
            [['first_name', 'last_name', 'second_name'], 'string', 'max' => 80],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 50],
            [['badge_number'], 'string', 'max' => 4],
            [['sms_code', 'sms_result'], 'string'],
            [['isValidSmsCode', 'user_id'], 'integer'],
            ['member_form_scenario', 'string'],
            ['check_status', 'integer'],
            ['badge_issued', 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'second_name' => 'Отчество',
            'phone' => 'Телефон',
            'email' => 'Email',
            'sms_code' => 'SMS-код',
            'sms_result' => 'Результат отправки SMS',
            'isValidSmsCode' => 'Телефон подтвержден',
            'badge_number' => 'Номер бейджа',
            'user_id' => 'ID пользователя представителя',
            'member_form_scenario' => 'Сценарий формы создания участника',
            'check_status' => 'Статус проверки анкеты',
            'badge_issued' => 'Бейдж выдан',
            'created' => 'Дата и время создания записи',
            'updated' => 'Дата и время обновления записи',
        ];
    }
}
