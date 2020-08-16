<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 19:33
 */

namespace common\models\Team;


use common\models\MemberMain\BaseMemberMain;
use common\models\MemberPupils\BaseMemberPupils;
use common\models\MemberUniversities\BaseMemberUniversities;
use common\models\NominationTeam\BaseNominationTeam;


/**
 * Class BaseTeam
 *
 * @property BaseNominationTeam nominationsTeam read-onl
 * @property BaseMemberMain membersMain read-onl
 * @property BaseMemberPupils membersPupils read-onl
 * @property BaseMemberUniversities membersUniversities read-onl
 * @package common\models\Team
 */
class BaseTeam extends ModelTeam
{
    /**
     * Сеттер город регионального проведения
     * @param $city
     */
    public function setCityRegionalStage($city)
    {
        $this->city_regional_stage = $city;
    }

    /**
     * Сеттер имя команды
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Сеттер названия роли пользователя, котроый создал команду
     * @param user_create_role
     */
    public function setUserCreateRole($role)
    {
        $this->user_create_role = $role;
    }

    /**
     * Связь с номинациями команд
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNominationsTeam()
    {
        return $this->hasMany(BaseNominationTeam::className(), ['team_id' => 'id']);
    }

    /**
     * Связь с участниками (основными)
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMembersMain()
    {
        return $this->hasMany(BaseMemberMain::className(), ['team_id' => 'id']);
    }

    /**
     * Связь с участниками (школьники)
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMembersPupils()
    {
        return $this->hasMany(BaseMemberPupils::className(), ['team_id' => 'id']);
    }

    /**
     * Связь с участниками (университет)
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMembersUniversities()
    {
        return $this->hasMany(BaseMemberUniversities::className(), ['team_id' => 'id']);
    }
}