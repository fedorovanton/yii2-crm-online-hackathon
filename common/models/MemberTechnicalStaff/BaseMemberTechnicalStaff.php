<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 17/09/2019
 * Time: 09:56
 */

namespace common\models\MemberTechnicalStaff;
use common\models\MemberInfo\BaseMemberInfo;
use frontend\models\MemberInfo\MemberInfo;

/**
 * Class BaseMemberTechnicalStaff
 * @property MemberInfo memberInfo read-only
 * @package common\models\MemberTechnicalStaff
 */
class BaseMemberTechnicalStaff extends ModelMemberTechnicalStaff
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

    /**
     * Связь с сущностью инфо об участниках
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMemberInfo()
    {
        return $this->hasOne(BaseMemberInfo::className(), ['id' => 'member_info_id']);
    }
}