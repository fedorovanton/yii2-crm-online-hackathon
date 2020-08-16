<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 19:07
 */

namespace frontend\models\MemberInfo;


use common\components\Role;
use common\components\SmsService;
use common\models\MemberGuests\BaseMemberGuests;
use common\models\MemberGuests\ModelMemberGuests;
use common\models\MemberInfo\BaseMemberInfo;
use common\models\MemberJury\BaseMemberJury;
use common\models\MemberJury\ModelMemberJury;
use common\models\MemberManagement\BaseMemberManagement;
use common\models\MemberManagement\ModelMemberManagement;
use common\models\MemberModerators\BaseMemberModerators;
use common\models\MemberModerators\ModelMemberModerators;
use common\models\MemberPartners\BaseMemberPartners;
use common\models\MemberPartners\ModelMemberPartners;
use common\models\MemberPress\BaseMemberPress;
use common\models\MemberPress\ModelMemberPress;
use common\models\MemberPupils\BaseMemberPupils;
use common\models\MemberPupils\ModelMemberPupils;
use common\models\MemberSecurityService\BaseMemberSecurityService;
use common\models\MemberSecurityService\ModelMemberSecurityService;
use common\models\MemberTechnicalStaff\BaseMemberTechnicalStaff;
use common\models\MemberTechnicalStaff\ModelMemberTechnicalStaff;
use common\models\MemberUniversities\BaseMemberUniversities;
use common\models\MemberUniversities\ModelMemberUniversities;
use common\models\MemberVolunteers\BaseMemberVolunteers;
use common\models\MemberVolunteers\ModelMemberVolunteers;
use common\models\User;
use frontend\forms\MemberForm;
use frontend\models\MemberMain\MemberMain;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use Yii;

/**
 * Дополнительные методы класса для фронтенд части
 *
 * Class MemberInfo
 * @property MemberMain memberMain read-only
 * @property BaseMemberUniversities memberUniversities read-only
 * @property BaseMemberPupils memberPupils read-only
 * @property BaseMemberTechnicalStaff memberTechnicalStaff read-only
 * @property BaseMemberSecurityService memberSecurityService read-only
 * @property BaseMemberPartners memberPartners read-only
 * @property BaseMemberPress memberPress read-only
 * @property BaseMemberModerators memberModerators read-only
 * @property BaseMemberGuests memberGuests read-only
 * @property BaseMemberJury memberJury read-only
 * @property BaseMemberVolunteers memberVolunteers read-only
 * @property BaseMemberManagement memberManagement read-only
 * @property User user read-only
 *
 * @package frontend\models\MemberInfo
 */
class MemberInfo extends BaseMemberInfo
{
    /**
     * Найти участника по телефону
     *
     * @param $phone
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findMemberByPhone($phone)
    {
        return self::find()->where(['phone' => $phone])->one();
    }

    /**
     * Найти участника по ID
     *
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findMemberById($id)
    {
        return self::find()->where(['id' => $id])->one();
    }

    /**
     * Проверить SMS код на валидность
     * @param $code
     * @return bool
     */
    public function checkValidSmsCode($code)
    {
        if ($this->sms_code == $code) {
            $this->setIsValidSmsCode(self::IS_VALID_SMS_CODE);
            $this->generateToken();
            $this->setUpdated();
            if (!$this->update()) {
                VarDumper::dump($this->errors, 10, true);die;
            }
            return true;
        }
        return false;
    }

    /**
     * Генерирует код из 4 случайных чисел
     * @return string
     */
    public static function generateSmsCode()
    {
        $code = '';
        for ($i=0;$i<4;$i++) {
            $code .= rand(0,9);
        }
        return $code;
    }

    /**
     * Отправка SMS-кода для проверки участнику
     */
    public function sendSmsCode()
    {
        if (Yii::$app->params['sms.canSend']) {
            $code = self::generateSmsCode();

            // Отправка смс кода через компонент SMSRRU
            $sms = new SmsService();
            $sms_result = $sms->send($this->phone, $code);
        } else {
            $code = Yii::$app->params['sms.codeDefault'];
            $sms_result = 'DEFAULT_SMS';
        }

        $this->setSmsResult($sms_result);
        $this->setSmsCode($code);
        $this->setUpdated();
        if (!$this->update()) {
            VarDumper::dump($this->errors);die;
        }
    }


    /**
     * Связь с сущностью Пользователи
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Связь с сущностью Основные участники
     * @return \yii\db\ActiveQuery
     */
    public function getMemberMain()
    {
        return $this->hasOne(MemberMain::className(), ['member_info_id' => 'id']);
    }

    /**
     * Связь с сущностью Гости
     * @return \yii\db\ActiveQuery
     */
    public function getMemberGuests()
    {
        return $this->hasOne(BaseMemberGuests::className(), ['member_info_id' => 'id']);
    }

    /**
     * Связь с сущностью Жюри
     * @return \yii\db\ActiveQuery
     */
    public function getMemberJury()
    {
        return $this->hasOne(BaseMemberJury::className(), ['member_info_id' => 'id']);
    }

    /**
     * Связь с сущностью Организаторы
     * @return \yii\db\ActiveQuery
     */
    public function getMemberManagement()
    {
        return $this->hasOne(BaseMemberManagement::className(), ['member_info_id' => 'id']);
    }

    /**
     * Связь с сущностью Модераторы
     * @return \yii\db\ActiveQuery
     */
    public function getMemberModerators()
    {
        return $this->hasOne(BaseMemberModerators::className(), ['member_info_id' => 'id']);
    }

    /**
     * Связь с сущностью Партеры
     * @return \yii\db\ActiveQuery
     */
    public function getMemberPartners()
    {
        return $this->hasOne(BaseMemberPartners::className(), ['member_info_id' => 'id']);
    }

    /**
     * Связь с сущностью Пресса
     * @return \yii\db\ActiveQuery
     */
    public function getMemberPress()
    {
        return $this->hasOne(BaseMemberPress::className(), ['member_info_id' => 'id']);
    }

    /**
     * Связь с сущностью Служба безопасности
     * @return \yii\db\ActiveQuery
     */
    public function getMemberSecurityService()
    {
        return $this->hasOne(BaseMemberSecurityService::className(), ['member_info_id' => 'id']);
    }

    /**
     * Связь с сущностью Технический персонал
     * @return \yii\db\ActiveQuery
     */
    public function getMemberTechnicalStaff()
    {
        return $this->hasOne(BaseMemberTechnicalStaff::className(), ['member_info_id' => 'id']);
    }

    /**
     * Связь с сущностью Участники (опорные вузы)
     * @return \yii\db\ActiveQuery
     */
    public function getMemberUniversities()
    {
        return $this->hasOne(BaseMemberUniversities::className(), ['member_info_id' => 'id']);
    }

    /**
     * Связь с сущностью Волонтеры
     * @return \yii\db\ActiveQuery
     */
    public function getMemberVolunteers()
    {
        return $this->hasOne(BaseMemberVolunteers::className(), ['member_info_id' => 'id']);
    }

    /**
     * Связь с сущностью Участники (школьники)
     * @return \yii\db\ActiveQuery
     */
    public function getMemberPupils()
    {
        return $this->hasOne(BaseMemberPupils::className(), ['member_info_id' => 'id']);
    }

    /**
     * Определить с какой сущностью связана таблица MemberInfo.
     * Определяем по названию сценарию, который хранится в поле member_form_scenario
     * Получилось громоздко, и нуждается в ручной доработке. Но УВЫ) время подижмало для создания хорошей реализации.
     *
     * P.S.: можно было сделать через Model::getRelation(),
     * но тогда бы логика была сложной и в других местах нельзя было бы адекватно ее использовать
     *
     * @param $scenario
     * @return mixed
     */
    public static function findRelationByMemberFormScenario($scenario)
    {
        switch ($scenario) {
            case MemberForm::SCENARIO_MEMBER_MAIN:
                $relation = 'memberMain';
                break;
            case MemberForm::SCENARIO_MEMBERS_UNIVERSITIES:
                $relation = 'memberUniversities';
                break;
            case MemberForm::SCENARIO_MEMBERS_PUPILS:
                $relation = 'memberPupils';
                break;
            case MemberForm::SCENARIO_TECHNICAL_STAFF:
                $relation = 'memberTechnicalStaff';
                break;
            case MemberForm::SCENARIO_SECURITY_SERVICE:
                $relation = 'memberSecurityService';
                break;
            case MemberForm::SCENARIO_PARTNERS:
                $relation = 'memberPartners';
                break;
            case MemberForm::SCENARIO_PRESS:
                $relation = 'memberPress';
                break;
            case MemberForm::SCENARIO_MODERATORS:
                $relation = 'memberModerators';
                break;
            case MemberForm::SCENARIO_GUESTS:
                $relation = 'memberGuests';
                break;
            case MemberForm::SCENARIO_JURY:
                $relation = 'memberJury';
                break;
            case MemberForm::SCENARIO_VOLUNTEERS:
                $relation = 'memberVolunteers';
                break;
            case MemberForm::SCENARIO_MANAGEMENT:
                $relation = 'memberManagement';
                break;
            default: $relation = null;
        }

        return $relation;
    }

    /**
     * Сделать из полученных записей ActiveRecord массив для select
     * @param $members
     * @return array
     */
    private static function _arrayMapMemberList($members)
    {
        return ArrayHelper::map($members, 'id', function ($model) {
            /** @var $model MemberInfo */
            return $model->first_name . ' ' . $model->last_name;
        });
    }

    /**
     * Получить список участников, которых создал указанный пользователь
     *
     * @param $userOwner
     * @param bool $isMissingTeam
     * @param array|null $addMemberInfoIdsArray
     * @return array
     */
    public static function getMembersArray($userOwner, $isMissingTeam = false, array $addMemberInfoIdsArray = null)
    {
        $members = self::find();

        // Определяем какие участники нужны
        $members->where(['member_form_scenario' => $userOwner->role]);

        // Нужны участники, у которых еще нет команды
        if ($isMissingTeam) {
            switch ($userOwner->role) {
                case Role::MEMBERS_MAIN:
                    $members
                        ->joinWith('memberMain')
                        ->andWhere(['IS', 'member_main.team_id', null]);
                    break;
                case Role::MEMBERS_UNIVERSITIES:
                    $members
                        ->joinWith('memberUniversities')
                        ->andWhere(['IS', 'member_universities.team_id', null]);
                    break;
                case Role::MEMBERS_PUPILS:
                    $members
                        ->joinWith('memberPupils')
                        ->andWhere(['IS', 'member_pupils.team_id', null]);
                    break;
            }
        }

        /** @var $userOwner User */
        if ($userOwner->role != Role::MEMBERS_MAIN) {
            $members->andWhere(['user_id' => $userOwner->id]);
        }

        // Получить список
        $membersInfoArray = self::_arrayMapMemberList($members->all());

        // Есть ли массив с участниками, которые обязательно добавить в выборку
        // P.S. обычно это список при редактировании команд, у ккоторых есть команда, но они редактируются
        if (!empty($addMemberInfoIdsArray)) {
            foreach ($addMemberInfoIdsArray as $member_info_id) {
                $member_info = MemberInfo::find()->where(['id' => $member_info_id])->all();
                if ($member_info) {
                    $membersInfoArray = ArrayHelper::merge($membersInfoArray, self::_arrayMapMemberList($member_info));
                }
            }
        }

        return $membersInfoArray;
    }
}