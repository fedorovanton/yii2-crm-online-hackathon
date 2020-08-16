<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 17/09/2019
 * Time: 16:55
 */

namespace common\models\MemberManagement;


use yii\helpers\ArrayHelper;


/**
 * Class BaseMemberManagement
 * @package common\models\MemberManagement
 */
class BaseMemberManagement extends ModelMemberManagement
{
    /**
     * Статус - Дирекция
     */
    const STATUS_DIRECTORATE = 1;

    /**
     * Статус - Организатор
     */
    const STATUS_ORGANIZER = 2;

    /**
     * Геттер массив статусов
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_DIRECTORATE => 'Дирекция',
            self::STATUS_ORGANIZER => 'Организатор',
        ];
    }

    /**
     * Геттер значение статуса
     *
     * @return mixed
     */
    public function getStatusValue()
    {
        return ArrayHelper::getValue(self::getStatusArray(), $this->status);
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
     * Сеттер статус
     * @param $status
     */
    public function setStatus($status)
    {
        $this->status = (string)$status;
    }

    /**
     * Сеттер ID инфо об участнике
     *
     * @param $memberInfoId
     */
    public function setMemberInfoId($memberInfoId)
    {
        $this->member_info_id = $memberInfoId;
    }
}