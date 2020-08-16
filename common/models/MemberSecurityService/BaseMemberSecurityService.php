<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 17/09/2019
 * Time: 15:05
 */

namespace common\models\MemberSecurityService;

/**
 * Class BaseMemberSecurityService
 * @package common\models\MemberSecurityService
 */
class BaseMemberSecurityService extends ModelMemberSecurityService
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
     *
     * @param $memberInfoId
     */
    public function setMemberInfoId($memberInfoId)
    {
        $this->member_info_id = $memberInfoId;
    }
}