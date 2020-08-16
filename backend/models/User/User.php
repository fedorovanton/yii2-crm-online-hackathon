<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 16/09/2019
 * Time: 12:19
 */

namespace backend\models\User;


use frontend\models\MemberInfo\MemberInfo;

/**
 * Class User
 * @package backend\models\User
 */
class User extends \common\models\User
{
    /**
     * Количество участников у пользователя
     */
    public function numberMembersPerUser()
    {
        return MemberInfo::find()
            ->where(['user_id' => $this->id])
            ->count();
    }
}