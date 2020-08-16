<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 19/09/2019
 * Time: 10:39
 */

namespace frontend\forms;


use common\components\Role;
use common\models\MemberMain\BaseMemberMain;
use common\models\MemberPupils\BaseMemberPupils;
use common\models\MemberUniversities\BaseMemberUniversities;
use common\models\Nomination\BaseNomination;
use common\models\NominationTeam\BaseNominationTeam;
use common\models\Team\BaseTeam;
use frontend\models\MemberInfo\MemberInfo;
use frontend\models\MemberMain\MemberMain;
use frontend\models\Team\Team;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * Форма создания команды для участников
 *
 * Class TeamForm
 * @package frontend\forms
 */
class TeamForm extends Model
{
    // Поля для команды
    public $name;
    public $city_regional_stage;
    public $user_id;
    public $user_create_role;

    // Поля для номинаций
    public $nomination_id_1;
    public $nomination_id_2;
    public $nomination_id_3;
    public $nomination_id_final;

    // Участники
    public $member_info_id_1;
    public $member_info_id_2;
    public $member_info_id_3;
    public $member_info_id_4;
    public $member_info_id_5;

    // Капитан из участников
    public $member_number_is_captain;

    // ID команды
    public $team_id;

    // Сценарии соответствуют ролям пользователей
    const SCENARIO_MEMBER_MAIN = Role::MEMBERS_MAIN;
    const SCENARIO_MEMBERS_UNIVERSITIES = Role::MEMBERS_UNIVERSITIES;
    const SCENARIO_MEMBERS_PUPILS = Role::MEMBERS_PUPILS;

    /**
     * @inheritdoc
     * @return array
     */
    public function scenarios()
    {
        /** @var $default array - это общие поля для всех сущностей с участниками */
        $default = [
            'name',
            'member_info_id_1',
            'member_info_id_2',
            'member_info_id_3',
            'member_info_id_4',
            'member_info_id_5',
            'team_id',
        ];

        return [
            // У каждого сценария свой список полей + Общие поля
            self::SCENARIO_MEMBER_MAIN => ArrayHelper::merge($default, [
                'city_regional_stage',
                'nomination_id_1',
                'nomination_id_2',
                'nomination_id_3',
                'nomination_id_final',
                'member_number_is_captain',
            ]),
            self::SCENARIO_MEMBERS_UNIVERSITIES => ArrayHelper::merge($default, [
                'nomination_id_final',
            ]),
            self::SCENARIO_MEMBERS_PUPILS => ArrayHelper::merge($default, [
                'nomination_id_final',
            ]),
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            // Название команды
            ['name', 'required'],
            ['name', 'string', 'max' => 255],

            // Участники
            [['member_info_id_1', 'member_info_id_2', 'member_info_id_3', 'member_info_id_4', 'member_info_id_5'], 'integer'],
            [['member_info_id_1', 'member_info_id_2', 'member_info_id_3', 'member_info_id_4', 'member_info_id_5'], 'validateMembersIsAlreadySelected'],

            // Является капитаном
            ['member_number_is_captain', 'required', 'on' => [
                self::SCENARIO_MEMBER_MAIN,
            ]],
            ['member_number_is_captain', 'integer'],

            // Город проведения регионального этапа
            ['city_regional_stage', 'required', 'on' => [
                self::SCENARIO_MEMBER_MAIN,
            ]],
            ['city_regional_stage', 'string'],

            // Номинации
            [['nomination_id_1', 'nomination_id_2', 'nomination_id_3'], 'required', 'on' => [
                self::SCENARIO_MEMBER_MAIN,
            ]],
            [['nomination_id_1', 'nomination_id_2', 'nomination_id_3'], 'integer'],

            // Итоговая номинация
            ['nomination_id_final', 'required', 'on' => [
                self::SCENARIO_MEMBERS_UNIVERSITIES,
            ]],
            ['nomination_id_final', 'integer'],

            // ID команды
            ['team_id', 'integer'],
        ];
    }

    /**
     * Валиадтор для участников
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function validateMembersIsAlreadySelected($attribute, $params)
    {
        $membersArray = [
            $this->member_info_id_1,
            $this->member_info_id_2,
            $this->member_info_id_3,
            $this->member_info_id_4,
            $this->member_info_id_5,
        ];

        $membersFilterArray = array_filter($membersArray); // Убрать пустые элементы
        $membersCountArray = array_count_values($membersFilterArray); // Количество каждого элемента

        foreach ($membersCountArray as $value) {
            if ($value > 1) {
                $this->addError($attribute, 'Нельзя выбирать одинаковых участников!');
            }
        }

        return true;
    }


    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название команды',
            'city_regional_stage' => 'Город проведения регионального этап',
            'user_id' => 'ID пользователя',
            'user_create_role' => 'ID роли пользователя',
            'nomination_id_1' => 'Номинация приоритет 1',
            'nomination_id_2' => 'Номинация приоритет 2',
            'nomination_id_3' => 'Номинация приоритет 3',
            'nomination_id_final' => 'Итоговая номинация',
            'member_info_id_1' => 'Участника 1',
            'member_info_id_2' => 'Участника 2',
            'member_info_id_3' => 'Участника 3',
            'member_info_id_4' => 'Участника 4',
            'member_info_id_5' => 'Участника 5',
            'member_number_is_captain' => 'Является капитаном',
        ];
    }

    /**
     * Обновление информации в участнице
     *
     * @param $team_id integer ID команды
     * @param $member_info_id integer ID инфо участника
     * @param $user
     * @param $member_position integer Позиция участника в команде
     */
    private function _updateMember($team_id, $member_info_id, $user, $member_position)
    {
        // Ищем инфо об участнике
        /** @var MemberInfo $member_info */
        $member_info = MemberInfo::find()->where(['id' => $member_info_id])->one();
        if (!empty($member_info)) {

            // Определяем с какой сущностью связана инфа об участнике
            switch ($this->scenario) {
                case self::SCENARIO_MEMBER_MAIN: $member = $member_info->memberMain; break;
                case self::SCENARIO_MEMBERS_UNIVERSITIES: $member = $member_info->memberUniversities; break;
                case self::SCENARIO_MEMBERS_PUPILS: $member = $member_info->memberPupils; break;
            }

            // Если связь есть
            if (!empty($member)) {

                /** @var MemberMain $member */
                $member->team_id = $team_id; // присваиваем ID команд

                if (in_array($this->scenario, [self::SCENARIO_MEMBER_MAIN])) {
                    // Для основных участников выбираем Капитана/Участника
                    $member->setTeamStatus(($this->member_number_is_captain == 1) ? MemberMain::TEAM_STATUS_CAPTAIN : MemberMain::TEAM_STATUS_MEMBER);
                    $member->setMemberPosition($member_position);
                } else {
                    // Для остальных участников нету капитанов, все являются участниками
                    $member->setTeamStatus(MemberMain::TEAM_STATUS_MEMBER);
                    $member->setMemberPosition($member_position);
                }

                $member->setUpdated();
                $member->update();
            }
        }
    }

    /**
     * Создание номинации для команды
     *
     * @param $team_id
     * @param $nomination_id
     * @param $priority
     */
    private function _updateOrCreateNominationTeam($team_id, $nomination_id, $priority)
    {
        // Проверяем есть ли у команды такая номинация
        /** @var BaseNominationTeam $nomination_team */
        $nomination_team = BaseNominationTeam::find()
            ->where(['team_id' => $team_id])
            ->andWhere(['nomination_id' => $nomination_id])
            ->one();

        if ($nomination_team) {
            // если номинация у команды уже есть, то просто обновляем приоритет (даже если он не менялся)

            $nomination_team->setPriority($priority);
            $nomination_team->setUpdated();
            $nomination_team->update();
        } else {

            // если номинации еще нет у команды, то сначала удаляем запись с этим приоритетом, если она есть
            $nomination_team = BaseNominationTeam::find()
                ->where(['team_id' => $team_id])
                ->andWhere(['priority' => $priority])
                ->one();

            if ($nomination_team) {
                $nomination_team->delete();
            }

            // затем добавляем эту номинацию для команды с указанным приоритетом
            $nomination_team = new BaseNominationTeam();
            $nomination_team->setTeamId($team_id);
            $nomination_team->setNominationId($nomination_id);
            $nomination_team->setPriority($priority);
            $nomination_team->setUpdated();
            $nomination_team->setCreated();
            if (!$nomination_team->save()) {
                VarDumper::dump($nomination_team->errors, 10, true);die;
            }
        }
    }

    /**
     * Очистить ID участников в команде, для дальнейшего обновления
     *
     * @param Team $team
     * @return bool
     */
    private function _clearTeamIdInMember(Team $team)
    {
        // Определяем с какой сущностью связана команда
        switch ($team->user_create_role) {
            case Role::MEMBERS_MAIN: $relation = 'membersMain'; break;
            case Role::MEMBERS_UNIVERSITIES: $relation = 'membersUniversities'; break;
            case Role::MEMBERS_PUPILS: $relation = 'membersPupils'; break;
            default: return false;
        }

        // Заполняем форму участниками из сущности, которую определили
        if ($team->$relation) {
            foreach ($team->$relation as $member) {
                /** @var BaseMemberMain $member */
                /** @var BaseMemberUniversities $member */
                /** @var BaseMemberPupils $member */
                $member->setTeamId(null); // очищаем привязку к команде
                $member->setTeamStatus(MemberMain::TEAM_STATUS_MEMBER); // по умолчанию делаем что опять участник
                $member->setUpdated();
                $member->update();
            }
        }

    }

    /**
     * Сервис создания записей в моделях данными из формы
     *
     * @param bool $isUpdateRecord Флаг обновить запись
     * @return bool
     */
    public function saveDataInModels($isUpdateRecord = false)
    {
        $user = \Yii::$app->user->identity;

        if ($isUpdateRecord) {
            // Обновляем команду
            $team = Team::find()->where(['id' => $this->team_id])->one();
            if (empty($team)) { return false; }
            $team->setName($this->name);
            $team->setUserCreateRole($user->role);
            $team->setUserId($user->getId());
            $team->setUpdated();
            if (!$team->update()) {
                VarDumper::dump($team->errors, 10, true);die;
            }

            // Очистить список участников команды перед обновлением
            $this->_clearTeamIdInMember($team);
        } else {
            // Создаем команду
            /** @var Team $team */
            $team = new Team();
            if ($this->scenario == self::SCENARIO_MEMBER_MAIN) {
                $team->city_regional_stage = $this->city_regional_stage;
            }
            $team->setName($this->name);
            $team->setUserCreateRole($user->role);
            $team->setUserId($user->getId());
            $team->setUpdated();
            $team->setCreated();
            if (!$team->save()) {
                VarDumper::dump($team->errors, 10, true);die;
                return false;
            }
        }

        // Запоминаем в БД участника 1 от команды
        if (!empty($this->member_info_id_1)) {
            $this->_updateMember($team->id, $this->member_info_id_1, $user, 1);
        }

        // Запоминаем в БД участника 2 от команды
        if (!empty($this->member_info_id_2)) {
            $this->_updateMember($team->id, $this->member_info_id_2, $user, 2);
        }

        // Запоминаем в БД участника 3 от команды
        if (!empty($this->member_info_id_3)) {
            $this->_updateMember($team->id, $this->member_info_id_3, $user, 3);
        }

        // Запоминаем в БД участника 4 от команды
        if (!empty($this->member_info_id_4)) {
            $this->_updateMember($team->id, $this->member_info_id_4, $user, 4);
        }

        // Запоминаем в БД участника 5 от команды
        if (!empty($this->member_info_id_5)) {
            $this->_updateMember($team->id, $this->member_info_id_5, $user, 5);
        }

        // Запоминаем выбранные номинации команде
        switch ($this->scenario) {
            case self::SCENARIO_MEMBER_MAIN:
                // Для основных участников указывают 3 номинации
                $this->_updateOrCreateNominationTeam($team->id, $this->nomination_id_1, BaseNominationTeam::PRIORITY_1);
                $this->_updateOrCreateNominationTeam($team->id, $this->nomination_id_2, BaseNominationTeam::PRIORITY_2);
                $this->_updateOrCreateNominationTeam($team->id, $this->nomination_id_3, BaseNominationTeam::PRIORITY_3);
                break;
            case self::SCENARIO_MEMBERS_UNIVERSITIES:
                // Для студентов выбирают итоговую номинацию
                $this->_updateOrCreateNominationTeam($team->id, $this->nomination_id_final, BaseNominationTeam::PRIORITY_FINAL);
                break;
            case self::SCENARIO_MEMBERS_PUPILS:
                // Для школьников номинация уже выбрана по дефолту

                // фиксированная номинация "Школьная номинация"
                /** @var BaseNomination $nomination */
                $nomination = BaseNomination::find()->where(['name' => 'Школьная номинация'])->one();
                if ($nomination) {
                    $this->_updateOrCreateNominationTeam($team->id, $nomination->id, BaseNominationTeam::PRIORITY_FINAL);
                }
                break;
        }
    }

    /**
     * Заполнить поля формы номинациями команд
     *
     * @param Team $team
     */
    public function _fillNominationTeam(Team $team)
    {
        if ($team->nominationsTeam) {
            foreach ($team->nominationsTeam as $nomination_team) {
                /** @var $nomination_team BaseNominationTeam */
                switch ($nomination_team->priority) {
                    case BaseNominationTeam::PRIORITY_1:
                        $this->nomination_id_1 = $nomination_team->nomination_id;
                        break;
                    case BaseNominationTeam::PRIORITY_2:
                        $this->nomination_id_2 = $nomination_team->nomination_id;
                        break;
                    case BaseNominationTeam::PRIORITY_3:
                        $this->nomination_id_3 = $nomination_team->nomination_id;
                        break;
                    case BaseNominationTeam::PRIORITY_FINAL:
                        $this->nomination_id_final = $nomination_team->nomination_id;
                        break;
                }
            }
        }
    }

    /**
     * Заполнение формы участниками (или основными, или школьниками, или студентами)
     *
     * @param Team $team
     * @return bool
     */
    public function _fillMembers(Team $team)
    {
        // Определяем с какой сущностью связана команда
        switch ($team->user_create_role) {
            case Role::MEMBERS_MAIN: $relation = 'membersMain'; break;
            case Role::MEMBERS_UNIVERSITIES: $relation = 'membersUniversities'; break;
            case Role::MEMBERS_PUPILS: $relation = 'membersPupils'; break;
            default: return false;
        }

        // Заполняем форму участниками из сущности, которую определили
        if ($team->$relation) {

            $num = 1; // Это порядковый номер участника (Участник 1, Участник 2...)

            foreach ($team->$relation as $member) {
                /** @var BaseMemberMain $member */
                /** @var BaseMemberUniversities $member */
                /** @var BaseMemberPupils $member */

                // Формируем название поля формы, в котором будет храниться ID участника
                $name_form_member_info_id = 'member_info_id_'.$num;

                $this->$name_form_member_info_id = $member->member_info_id;

                // Если статус участника в команде == Капитан, то зафиксируем это
                if ($member->team_status == MemberMain::TEAM_STATUS_CAPTAIN) {
                    $this->member_number_is_captain = $num;
                }

                $num++;
            }
        }
    }

    /**
     * Заполнить форму данными из моделей
     *
     * @param Team $model
     * @return bool
     */
    public function fillForm(Team $model)
    {
        // Заполняем форму данными из Team
        $this->attributes = $model->attributes;
        $this->team_id = $model->id;

        // Номинация
        $this->_fillNominationTeam($model);

        // Участники
        $this->_fillMembers($model);
    }
}