<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 17/09/2019
 * Time: 15:25
 */

namespace common\models\MemberPartners;

/**
 * Class BaseMemberPartners
 * @package common\models\MemberPartners
 */
class BaseMemberPartners extends ModelMemberPartners
{
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
     * Сеттер название организации
     * @param $name_organization
     */
    public function setNameOrganization($name_organization)
    {
        $this->name_organization = $name_organization;
    }
}