<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 19:24
 */

namespace frontend\models\Team;


use common\components\Role;
use common\models\MemberMain\BaseMemberMain;
use common\models\MemberPupils\BaseMemberPupils;
use common\models\MemberUniversities\BaseMemberUniversities;
use common\models\NominationTeam\BaseNominationTeam;
use common\models\Team\BaseTeam;
use frontend\models\MemberMain\MemberMain;

/**
 * Class Team
 * @package frontend\models\Team
 */
class Team extends BaseTeam
{
    /**
     * {@inheritdoc}
     * @return TeamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeamQuery(get_called_class());
    }

    /**
     * Найти команду по имени
     *
     * @param $name
     * @return array|Team|null
     */
    public static function findByName($name)
    {
        return self::find()->where(['name' => $name])->one();
    }

    /**
     * Найти команду по имени и пользователю представителя
     *
     * @param $name
     * @param $userId
     * @return array|Team|null
     */
    public static function findByNameAndUserId($name, $userId)
    {
        return self::find()
            ->where(['name' => $name])
            ->andWhere(['user_id' => $userId])
            ->one();
    }

    /**
     * Собарана ли команда или нет
     *      ОК - когда в команде 3-5 человек
     *      НЕТ - когда в команде 1-2 человека
     * @param $role
     * @return string
     */
    public function isAssembled($role)
    {
        switch ($role) {
            case Role::MEMBERS_MAIN:
                $count = BaseMemberMain::find()->where(['team_id' => $this->id])->count();
                break;
            case Role::MEMBERS_UNIVERSITIES:
                $count = BaseMemberUniversities::find()->where(['team_id' => $this->id])->count();
                break;
            case Role::MEMBERS_PUPILS:
                $count = BaseMemberPupils::find()->where(['team_id' => $this->id])->count();
                break;
            default:
                return 'Не определено';
        }

        if ($count > 2) {
            return 'OK';
        } else {
            return 'НЕТ';
        }
    }

    /**
     * Количество основных участников в команде
     * @return int|string
     */
    public function countMembersMainInTeam()
    {
        return BaseMemberMain::find()->where(['team_id' => $this->id])->count();
    }

    /**
     * @param $priority
     * @return string
     */
    public function getNominationTeamByPriority($priority)
    {
        if (isset($this->nominationsTeam)) {
            foreach ($this->nominationsTeam as $nomination_team) {
                /** @var $nomination_team BaseNominationTeam */
                if ($priority == $nomination_team->priority) {
                    return $nomination_team->nomination->name;
                }
            }
        }

        return 'НЕТ';
    }

}