<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 17/09/2019
 * Time: 16:39
 */

namespace common\models\MemberJury;


use common\models\Nomination\BaseNomination;
use yii\helpers\ArrayHelper;


/**
 * Class BaseMemberJury
 * @property BaseNomination nomination read-only
 * @package common\models\MemberJury
 */
class BaseMemberJury extends ModelMemberJury
{
    /**
     * Статус - Жюри
     */
    const STATUS_JURY = 1;

    /**
     * Статус - Эксперт
     */
    const STATUS_EXPERT = 2;

    /**
     * Геттер массив статусов
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_JURY => 'Жюри',
            self::STATUS_EXPERT => 'Эксперт',
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
        $this->status = $status;
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

    /**
     * Сеттер ID номинации
     * @param $nomination_id
     */
    public function setNominationId($nomination_id)
    {
        $this->nomination_id = $nomination_id;
    }

    /**
     * Сеттер место работы
     * @param $place_work
     */
    public function setPlaceWork($place_work)
    {
        $this->place_work = $place_work;
    }

    /**
     * Сеттер должности
     * @param $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Связь с номинациями
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNomination()
    {
        return $this->hasOne(BaseNomination::className(), ['id' => 'nomination_id']);
    }
}