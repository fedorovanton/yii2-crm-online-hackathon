<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 17/09/2019
 * Time: 16:13
 */

namespace common\models\MemberGuests;


use common\models\Nomination\BaseNomination;
use yii\helpers\ArrayHelper;

/**
 * Class BaseMemberGuests
 * @property BaseNomination nomination read-only
 * @package common\models\MemberGuests
 */
class BaseMemberGuests extends ModelMemberGuests
{
    /**
     * Статус - Гость
     */
    const STATUS_GUEST = '1';

    /**
     * Статус - Почетный гость
     */
    const STATUS_VENERABLE_GUEST = '2';

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
     * @param $memberInfoId
     */
    public function setMemberInfoId($memberInfoId)
    {
        $this->member_info_id = $memberInfoId;
    }

    /**
     * Сеттер Место работы
     * @param $place_work
     */
    public function setPlaceWork($place_work)
    {
        $this->place_work = $place_work;
    }

    /**
     * Сеттер Должность на месте работы
     * @param $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Геттер массив статусов
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_GUEST => 'Гость',
            self::STATUS_VENERABLE_GUEST => 'Почтеный гость',
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
}