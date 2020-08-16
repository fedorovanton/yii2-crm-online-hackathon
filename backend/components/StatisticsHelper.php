<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 25/09/2019
 * Time: 14:53
 */

namespace backend\components;

use common\models\MemberGuests\BaseMemberGuests;
use common\models\MemberMain\BaseMemberMain;
use common\models\MemberManagement\BaseMemberManagement;
use common\models\MemberPupils\BaseMemberPupils;
use common\models\MemberUniversities\BaseMemberUniversities;
use common\models\Nomination\BaseNomination;
use frontend\forms\MemberForm;
use frontend\models\MemberInfo\MemberInfo;
use frontend\models\MemberMain\MemberMain;
use frontend\models\Team\Team;
use yii\helpers\VarDumper;

/**
 * Класс для расчетов и получения значений для раздела статистика
 *
 * Class StatisticsHelper
 * @package backend\components
 */
class StatisticsHelper
{
    /**
     * Всего участников и организаторов
     * @return int|string
     */
    public static function getAllCount()
    {
        // Считаю количество записей из таблицы member_info
        return MemberInfo::find()->count();
    }

    /**
     * Участники конкретной роли
     * @param $role
     * @return int|string
     */
    public static function getCountMemberByRole($role)
    {
        return MemberInfo::find()->where(['member_form_scenario' => $role])->count();
    }

    /**
     * Количество дирекции или менджмента по их статусу (Менеджмент, Диреция)
     * @param $status
     * @return int|string
     */
    public static function getCountManagementByStatus($status)
    {
        return BaseMemberManagement::find()->where(['status' => $status])->count();
    }

    /**
     * Количество гостей или почетных гостей по их статусу (Гости, Почетные гости)
     * @param $status
     * @return int|string
     */
    public static function getCountGuestByRole($status)
    {
        return BaseMemberGuests::find()->where(['status' => $status])->count();
    }

    /**
     * Всего команд
     * @return int|string
     */
    public static function getCountTeams()
    {
        return Team::find()->distinct()->count('name');
    }


    /**
     * Количество команд из 1, 2, 3, 4 или 5 человек
     *
     * @param $num
     * @return int
     */
    public static function getCountTeamsByNumPeople($num)
    {
//        SELECT team_id, count(team_id) as cnt
//        FROM member_pupils
//        GROUP BY team_id
//        HAVING cnt < 3

        $count = 0;

        $members_main = BaseMemberMain::find()->select('team_id, count(team_id) as cnt')->where(['IS NOT', 'team_id', null])->groupBy('team_id')->having(['=', 'cnt', $num])->all();
        $count += count($members_main);

        $members_universities = BaseMemberUniversities::find()->select('team_id, count(team_id) as cnt')->where(['IS NOT', 'team_id', null])->groupBy('team_id')->having(['=', 'cnt', $num])->all();
        $count += count($members_universities);

        $members_pupils = BaseMemberPupils::find()->select('team_id, count(team_id) as cnt')->where(['IS NOT', 'team_id', null])->groupBy('team_id')->having(['=', 'cnt', $num])->all();
        $count += count($members_pupils);

        return $count;
    }

    /**
     * Коилчество номинаций
     *
     * @return int|string
     */
    public static function getCountNominations()
    {
        return BaseNomination::find()->count();
    }
}