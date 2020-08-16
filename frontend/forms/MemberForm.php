<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 16/09/2019
 * Time: 15:19
 */

namespace frontend\forms;


use backend\models\User\User;
use common\components\Role;
use common\models\MemberGuests\BaseMemberGuests;
use common\models\MemberJury\BaseMemberJury;
use common\models\MemberManagement\BaseMemberManagement;
use common\models\MemberModerators\BaseMemberModerators;
use common\models\MemberPartners\BaseMemberPartners;
use common\models\MemberPress\BaseMemberPress;
use common\models\MemberPupils\BaseMemberPupils;
use common\models\MemberSecurityService\BaseMemberSecurityService;
use common\models\MemberTechnicalStaff\BaseMemberTechnicalStaff;
use common\models\MemberUniversities\BaseMemberUniversities;
use common\models\MemberVolunteers\BaseMemberVolunteers;
use frontend\models\MemberInfo\MemberInfo;
use frontend\models\MemberMain\MemberMain;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use Yii;


/**
 * Форма для ввода анкет любых участников
 *
 * Описание логики:
 *      1. Пользователь определенной роли (например Служба безопасности) может заполнять только список службы безопасности.
 *          При добавление участника в этот список ему присваивается id пользователя, который добавил для связки (один-ко-многим).
 *
 *      2. Для сущности Участники (основные) - это общий список. Здесь нет привязки пользователя к участнику.
 *          Много пользователей с ролью "Участники (основные)" могут заполнять общий список этих участников.
 *
 * Class MemberForm
 * @package frontend\forms
 */
class MemberForm extends Model
{
    public $last_name;
    public $first_name;
    public $second_name;
    public $missing_second_name;
    public $phone;
    public $email;
    public $clothing_size;
    public $region_residence;
    public $team_status;
    public $is_plans_live_in_city;
    public $address_live_in_city;
    public $badge_number;
    public $accept;
    public $status;
    public $agent_fio;
    public $agent_phone;
    public $name_organization;
    public $nomination_id;
    public $position;
    public $place_work;
    public $docFile;
    public $check_status; // todo ошибка на продакшене

    // Служебные поля
    public $member_info_id;
    public $member_id;
    public $doc_file;

    // Сценарии соответствуют ролям пользователей
    const SCENARIO_MEMBER_MAIN = Role::MEMBERS_MAIN;
    const SCENARIO_MEMBERS_UNIVERSITIES = Role::MEMBERS_UNIVERSITIES;
    const SCENARIO_MEMBERS_PUPILS = Role::MEMBERS_PUPILS;
    const SCENARIO_TECHNICAL_STAFF = Role::TECHNICAL_STAFF;
    const SCENARIO_SECURITY_SERVICE = Role::SECURITY_SERVICE;
    const SCENARIO_PARTNERS = Role::PARTNERS;
    const SCENARIO_PRESS = Role::PRESS;
    const SCENARIO_MODERATORS = Role::MODERATORS;
    const SCENARIO_GUESTS = Role::GUESTS;
    const SCENARIO_JURY = Role::JURY;
    const SCENARIO_VOLUNTEERS = Role::VOLUNTEERS;
    const SCENARIO_MANAGEMENT = Role::MANAGEMENT;

    /**
     * @inheritdoc
     * @return array
     */
    public function scenarios()
    {
        /** @var $default array - это общие поля для всех сущностей с участниками */
        $default = [
            'first_name',
            'last_name',
            'second_name',
            'missing_second_name',
            'phone',
            'email',
            'badge_number',
            'member_info_id',
            'member_id',
            'check_status', // todo ошибка на продакшене
        ];

        return [
            // У каждого сценария свой список полей + Общие поля
            self::SCENARIO_MEMBER_MAIN => ArrayHelper::merge($default, [
                'clothing_size',
                'region_residence',
                'team_status',
                'is_plans_live_in_city',
                'address_live_in_city',
                'doc_file',
                'docFile',
            ]),
            self::SCENARIO_MEMBERS_UNIVERSITIES => ArrayHelper::merge($default, [
                'clothing_size',
                'region_residence',
                'team_status',
                'is_plans_live_in_city',
                'address_live_in_city',
                'doc_file',
                'docFile',
            ]),
            self::SCENARIO_MEMBERS_PUPILS => ArrayHelper::merge($default, [
                'clothing_size',
                'region_residence',
                'team_status',
                'is_plans_live_in_city',
                'address_live_in_city',
                'agent_fio',
                'agent_phone',
                'doc_file',
                'docFile',
            ]),
            self::SCENARIO_TECHNICAL_STAFF => ArrayHelper::merge($default, [
                'status',
            ]),
            self::SCENARIO_SECURITY_SERVICE => ArrayHelper::merge($default, [
                'status',
            ]),
            self::SCENARIO_PARTNERS => ArrayHelper::merge($default, [
                'status',
                'name_organization',
            ]),
            self::SCENARIO_PRESS => ArrayHelper::merge($default, [
                'status',
                'name_organization',
            ]),
            self::SCENARIO_MODERATORS => ArrayHelper::merge($default, [
                'status',
            ]),
            self::SCENARIO_GUESTS => ArrayHelper::merge($default, [
                'status',
                'place_work',
                'position',
            ]),
            self::SCENARIO_JURY => ArrayHelper::merge($default, [
                'status',
                'place_work',
                'position',
                'nomination_id',
            ]),
            self::SCENARIO_VOLUNTEERS => ArrayHelper::merge($default, [
                'status',
            ]),
            self::SCENARIO_MANAGEMENT => ArrayHelper::merge($default, [
                'status',
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
            // ------ MemberInfo ------
            // Фамилия
            ['last_name', 'required', 'message' => 'Укажите вашу фамилию'],
            ['last_name', 'string', 'max' => 80],

            // Имя
            ['first_name', 'required', 'message' => 'Укажите ваше имя'],
            ['first_name', 'string', 'max' => 80],

            // Отчество
            ['second_name', 'required',
                'when' => function($model) {
                    return $model->missing_second_name != 'on';
                },
                'whenClient' => "function (attribute, value) {
                    return $('#memberform-missing_second_name').val() != 'on';
                }",
                'message' => 'Необходимо заполнить отчество.'
            ],
            ['second_name', 'string', 'max' => 80],

            // Нет отчество
            ['missing_second_name', 'string'],

            // Телефон
            ['phone', 'required', 'message' => 'Укажите ваш номер телефона', 'on' => [
                self::SCENARIO_MEMBER_MAIN,
                self::SCENARIO_MEMBERS_PUPILS,
                self::SCENARIO_MEMBERS_UNIVERSITIES,
                self::SCENARIO_TECHNICAL_STAFF,
                self::SCENARIO_SECURITY_SERVICE,
                self::SCENARIO_PARTNERS,
                self::SCENARIO_PRESS,
                self::SCENARIO_MODERATORS,
                self::SCENARIO_JURY,
                self::SCENARIO_VOLUNTEERS,
                self::SCENARIO_MANAGEMENT,
            ]],
            ['phone', 'string', 'max' => 20],
            ['phone', 'filter', 'filter' => [$this, 'normalizePhone']],

            // Email
            ['email', 'required', 'message' => 'Укажите email', 'on' => [
                self::SCENARIO_MEMBER_MAIN,
                self::SCENARIO_MEMBERS_PUPILS,
                self::SCENARIO_MEMBERS_UNIVERSITIES,
                self::SCENARIO_PARTNERS,
                self::SCENARIO_PRESS,
                self::SCENARIO_MODERATORS,
                self::SCENARIO_VOLUNTEERS,
                self::SCENARIO_MANAGEMENT,
            ]],
            ['email', 'string', 'max' => 50],

            // Номер бейджа
            ['badge_number', 'string', 'max' => 4],

            // Статус проверки анкеты
             ['check_status', 'integer'], // todo ошибка на продакшене

            // ------------------------------------------------------------------------

            // Документ
            ['docFile',
                'file',
                'skipOnEmpty' => true, // сделал чтобы можно было сохранять без загрузки файла
                'extensions' => 'pdf',
                'message' => 'Необходимо прикрепить pdf файл.',
                'on' => [
                    self::SCENARIO_MEMBER_MAIN, self::SCENARIO_MEMBERS_UNIVERSITIES, self::SCENARIO_MEMBERS_PUPILS
                ],
            ],

            // Размер одежды
            /*['clothing_size', 'required', 'message' => 'Укажите размер одежды', 'on' => [
                self::SCENARIO_MEMBER_MAIN, self::SCENARIO_MEMBERS_UNIVERSITIES, self::SCENARIO_MEMBERS_PUPILS
            ]],*/
            ['clothing_size', 'string', 'max' => 1024, 'on' => [
                self::SCENARIO_MEMBER_MAIN, self::SCENARIO_MEMBERS_UNIVERSITIES, self::SCENARIO_MEMBERS_PUPILS
            ]],

            // Регион проживания
            ['region_residence', 'required', 'message' => 'Укажите регион проживания', 'on' => [
                self::SCENARIO_MEMBER_MAIN, self::SCENARIO_MEMBERS_UNIVERSITIES, self::SCENARIO_MEMBERS_PUPILS
            ]],
            ['region_residence', 'string', 'max' => 255],

            // Статус в команде
            ['team_status', 'integer', 'on' => [
                self::SCENARIO_MEMBER_MAIN, self::SCENARIO_MEMBERS_UNIVERSITIES, self::SCENARIO_MEMBERS_PUPILS
            ]],

            // Планируете ли проживать в г. Казань
            /*['is_plans_live_in_city', 'required', 'message' => 'Вы должны указать будете ли проживать в г.Казань?', 'on' => [
                self::SCENARIO_MEMBER_MAIN, self::SCENARIO_MEMBERS_UNIVERSITIES
            ]],*/
            ['is_plans_live_in_city', 'string', 'max' => 3, 'on' => [
                self::SCENARIO_MEMBER_MAIN, self::SCENARIO_MEMBERS_UNIVERSITIES
            ]],

            // Адрес проживания в г. Казань
            ['address_live_in_city', 'required',
                'when' => function($model) {
                    return $model->is_plans_live_in_city == MemberMain::IS_LIVE_IN_KASAN;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#membermainpublicform-is_plans_live_in_city').val() == 'Да';
                }",
                'on' => [self::SCENARIO_MEMBER_MAIN, self::SCENARIO_MEMBERS_UNIVERSITIES],
                'message' => 'Вы должны указать адрес проживания в г.Казань.',
            ],
            ['address_live_in_city', 'string', 'max' => 255],

            // ------------------------------------------------------------------------

            // Статус
            [['status'], 'required', 'on' => [
                self::SCENARIO_GUESTS,
                self::SCENARIO_JURY,
                self::SCENARIO_MANAGEMENT,
            ]],
            [['status'], 'string', 'max' => 30, 'on' => [
                self::SCENARIO_TECHNICAL_STAFF,
                self::SCENARIO_SECURITY_SERVICE,
                self::SCENARIO_PARTNERS,
                self::SCENARIO_PRESS,
                self::SCENARIO_MODERATORS,
                self::SCENARIO_VOLUNTEERS,
            ]],

            // Название организации
            [['name_organization'], 'required', 'on' => [
                self::SCENARIO_PARTNERS,
                self::SCENARIO_PRESS,
            ]],
            [['name_organization'], 'string', 'max' => 255],

            // Номинация
            ['nomination_id', 'required', 'on' => [
                self::SCENARIO_JURY,
            ]],
            ['nomination_id', 'integer'],

            // Место работы
            ['place_work', 'required', 'on' => [
                self::SCENARIO_GUESTS,
                self::SCENARIO_JURY,
            ]],
            ['place_work', 'string', 'max' => 255],

            // Должность
            ['position', 'required', 'on' => [
                self::SCENARIO_GUESTS,
                self::SCENARIO_JURY,
            ]],
            ['position', 'string', 'max' => 255],

            // ФИО ответственного лица
            /*['agent_fio', 'required', 'on' => [
                self::SCENARIO_MEMBERS_PUPILS,
            ]],*/
            ['agent_fio', 'string', 'max' => 255],

            // Телефон ответственного лица
            /*['agent_phone', 'required', 'on' => [
                self::SCENARIO_MEMBERS_PUPILS,
            ]],*/
            ['agent_phone', 'string', 'max' => 20],
            ['agent_phone', 'filter', 'filter' => [$this, 'normalizePhone']],

            // ---- СЛУЖЕБНЫЕ ПОЛЯ
            ['member_info_id', 'integer'],
            ['member_id', 'integer'],
        ];
    }

    /**
     * Нормализует значение для телефона
     *
     * @param $value
     * @return mixed
     */
    public function normalizePhone($value) {
        // Было: +7 (910) 123-45-67
        // Стало: 89101234567

        $symbols = ['(', ')', '-', ' '];
        $value = str_replace($symbols, '', $value);
        $value = str_replace(['+7'], '8', $value);

        return $value;
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'second_name' => 'Отчество',
            'missing_second_name' => 'Нет отчество',
            'phone' => 'Телефон',
            'email' => 'Email',
            'clothing_size' => 'Размер одежды',
            'region_residence' => 'Регион проживания',
            'team_status' => 'Статус в команде',
            'is_plans_live_in_city' => 'Планируете ли проживать в г. Казань',
            'address_live_in_city' => 'Адрес проживания в г. Казань',
            'badge_number' => 'Номер бейджа',
            'check_status' => 'Статус проверки анкеты', // todo ошибка на продакшене

            'status' => 'Статус',
            'name_organization' => 'Название организации',
            'nomination_id' => 'ID номинации',
            'place_work' => 'Место работы',
            'position' => 'Должность',
            'agent_fio' => 'ФИО ответственного лица',
            'agent_phone' => 'Телефон ответственного лица',
            'docFile' => 'Документ',
        ];
    }

    /**
     * Создание объекта или поиск объекта модели соответствующей сущности в зависимости от сценария
     *
     * Если $isUpdateRecord = true, то пытаемся найти запись в соответствующей модели, если false - то создаем новый
     *
     * @param $isUpdateRecord
     * @return BaseMemberPupils|BaseMemberUniversities|MemberMain|null|static
     */
    private function _createOrFindMemberObject($isUpdateRecord)
    {
        switch ($this->scenario) {
            case self::SCENARIO_MEMBER_MAIN:
                if ($isUpdateRecord) {
                    $member = MemberMain::findOne($this->member_id);
                } else {
                    $member = new MemberMain();
                }
                break;
            case self::SCENARIO_MEMBERS_UNIVERSITIES:
                if ($isUpdateRecord) {
                    $member = BaseMemberUniversities::findOne($this->member_id);
                } else {
                    $member = new BaseMemberUniversities();
                }
                break;
            case self::SCENARIO_MEMBERS_PUPILS:
                if ($isUpdateRecord) {
                    $member = BaseMemberPupils::findOne($this->member_id);
                } else {
                    $member = new BaseMemberPupils();
                }
                break;
            case self::SCENARIO_TECHNICAL_STAFF:
                if ($isUpdateRecord) {
                    $member = BaseMemberTechnicalStaff::findOne($this->member_id);
                } else {
                    $member = new BaseMemberTechnicalStaff();
                }
                break;
            case self::SCENARIO_PARTNERS:
                if ($isUpdateRecord) {
                    $member = BaseMemberPartners::findOne($this->member_id);
                } else {
                    $member = new BaseMemberPartners();
                }
                break;
            case self::SCENARIO_PRESS:
                if ($isUpdateRecord) {
                    $member = BaseMemberPress::findOne($this->member_id);
                } else {
                    $member = new BaseMemberPress();
                }
                break;
            case self::SCENARIO_MODERATORS:
                if ($isUpdateRecord) {
                    $member = BaseMemberModerators::findOne($this->member_id);
                } else {
                    $member = new BaseMemberModerators();
                }
                break;
            case self::SCENARIO_GUESTS:
                if ($isUpdateRecord) {
                    $member = BaseMemberGuests::findOne($this->member_id);
                } else {
                    $member = new BaseMemberGuests();
                }
                break;
            case self::SCENARIO_JURY:
                if ($isUpdateRecord) {
                    $member = BaseMemberJury::findOne($this->member_id);
                } else {
                    $member = new BaseMemberJury();
                }
                break;
            case self::SCENARIO_VOLUNTEERS:
                if ($isUpdateRecord) {
                    $member = BaseMemberVolunteers::findOne($this->member_id);
                } else {
                    $member = new BaseMemberVolunteers();
                }
                break;
            case self::SCENARIO_MANAGEMENT:
                if ($isUpdateRecord) {
                    $member = BaseMemberManagement::findOne($this->member_id);
                } else {
                    $member = new BaseMemberManagement();
                }
                break;
            case self::SCENARIO_SECURITY_SERVICE:
                if ($isUpdateRecord) {
                    $member = BaseMemberSecurityService::findOne($this->member_id);
                } else {
                    $member = new BaseMemberSecurityService();
                }
                break;
            default:
                $member = new MemberMain();
        }
        return $member;
    }

    /**
     * Сервис создания записей в моделях данными из формы
     *
     * @param bool $isUpdateRecord Флаг обновить запись
     * @return bool
     */
    public function saveDataInModels($isUpdateRecord = false)
    {
        // Поля для сущности MemberInfo (заполняются для всех списков участников)
        if ($isUpdateRecord) {
            $member_info = MemberInfo::findOne($this->member_info_id);
            if (empty($member_info)) return false; // Если запись не найдена, то FALSE
        } else {
            $member_info = new MemberInfo();
        }
        $member_info->setLastName($this->last_name);
        $member_info->setFirstName($this->first_name);
        $member_info->setSecondName($this->second_name);
        $member_info->setPhone($this->phone);
        $member_info->setEmail($this->email);
        $member_info->setUserId(Yii::$app->user->getId());
        $member_info->setMemberFormScenario($this->scenario);
        $member_info->setCheckStatus($this->check_status);
        $member_info->setCreated();
        $member_info->setUpdated();
        if (!$member_info->save()) {
            VarDumper::dump('frontend/forms/MemberForm.php: сохранение MemberInfo', 10, true);
            VarDumper::dump($member_info->errors, 10, true);die;
        } else {
            $member_info->saveBadgeNumber(); // Сгененрировать и сохранить номер бейджа
        }

        // Создание объекта или поиск объекта модели соответствующей сущности в зависимости от сценария
        $member = $this->_createOrFindMemberObject($isUpdateRecord);
        if (empty($member)) return false;

        // Заполнение общих полей данными для всех сценариев
        $member->setCreated();
        $member->setUpdated();
        $member->setMemberInfoId($member_info->id);

        // Заполнение полей данными для разных сценариев
        if (in_array($this->scenario, [
            self::SCENARIO_MEMBER_MAIN, self::SCENARIO_MEMBERS_UNIVERSITIES, self::SCENARIO_MEMBERS_PUPILS
        ])) {
            $member->setClothingSize($this->clothing_size);
            $member->setRegionResidence($this->region_residence);
//            $member->setTeamId(null);
//            $member->setTeamStatus($this->team_status);
            if ($this->docFile) {
                $member->doc_file = $member->upload($this);
            }
        }

        // Заполнение полей Будете ли вы проживать в г Казань и Адрес в г Казань
        if (in_array($this->scenario, [
            self::SCENARIO_MEMBER_MAIN, self::SCENARIO_MEMBERS_UNIVERSITIES
        ])) {
            $member->setIsPlansLiveInCity($this->is_plans_live_in_city);
            $member->setAddressLiveInCity($this->address_live_in_city);
        }

        // Заполнение поля статус для тех, где уже заранее оно определено по дефолту
        if (in_array($this->scenario, [
            self::SCENARIO_TECHNICAL_STAFF,
            self::SCENARIO_SECURITY_SERVICE,
            self::SCENARIO_PARTNERS,
            self::SCENARIO_PRESS,
            self::SCENARIO_MODERATORS,
            self::SCENARIO_VOLUNTEERS,
        ])) {
            /** @var $member BaseMemberTechnicalStaff */
            // функция переворачивает статус Партнеры => в значение partners для БД
            $member->setStatus(User::getRoleNameEngByRoleRus($this->status));
        }

        // Заполнение поля статус для тех, где выпадающие списки
        if (in_array($this->scenario, [
            self::SCENARIO_GUESTS,
            self::SCENARIO_MANAGEMENT,
            self::SCENARIO_JURY,
        ])) {
            /** @var $member BaseMemberGuests */
            $member->setStatus($this->status);
        }

        // Заполнение поля название организации
        if (in_array($this->scenario, [
            self::SCENARIO_PARTNERS,
            self::SCENARIO_PRESS,
        ])) {
            /** @var $member BaseMemberPartners */
            $member->setNameOrganization($this->name_organization);
        }

        // Заполнение поля номинация
        if (in_array($this->scenario, [
            self::SCENARIO_JURY,
        ])) {
            /** @var $member BaseMemberJury */
            $member->setNominationId($this->nomination_id);
        }

        // Заполнение поелй должность и место работы
        if (in_array($this->scenario, [
            self::SCENARIO_GUESTS,
            self::SCENARIO_JURY,
        ])) {
            /** @var $member BaseMemberGuests */
            $member->setPlaceWork($this->place_work);
            $member->setPosition($this->position);
        }

        // Заполнение полей ФИО ответственного лица и Телефон ответственного лица
        if (in_array($this->scenario, [
            self::SCENARIO_MEMBERS_PUPILS,
        ])) {
            /** @var $member BaseMemberPupils */
            $member->setAgentFio($this->agent_fio);
            $member->setAgentPhone($this->agent_phone);
        }

        // Сохранение
        if (!$member->save()) {
            VarDumper::dump('frontend/forms/MemberForm.php: создание MemberForm', 10, true);
            VarDumper::dump($member->errors, 10, true);die;
        } else {
            return true;
        }
    }

    /**
     * Заполнить форму данными из моделей
     *
     * @param MemberInfo $model
     * @return bool
     */
    public function fillForm(MemberInfo $model)
    {
        // Получение названия связи с сущностью
        $relation = MemberInfo::findRelationByMemberFormScenario($this->scenario);

        // Создаем связь с сущностью MemberMain или MemberJury или тд.
        if (empty($relation)) {
            return false;
        } else {
            $member = $model->$relation;
        }

        // Заполняем форму данными из MemberInfo
        $this->attributes = $model->attributes;
        $this->member_info_id = $model->id;
        $this->member_id = $member->id;

        // Заполняем форму данными из других сущностей
        if (in_array($this->scenario, [
            self::SCENARIO_MEMBER_MAIN, self::SCENARIO_MEMBERS_UNIVERSITIES, self::SCENARIO_MEMBERS_PUPILS
        ])) {
            /** @var MemberMain $member */
            $this->clothing_size = $member->clothing_size;
            $this->region_residence = $member->region_residence;
            $this->team_status = $member->team_status;
            $this->doc_file = $member->doc_file;
        }

        // Заполнение полей Будете ли вы проживать в г Казань и Адрес в г Казань
        if (in_array($this->scenario, [
            self::SCENARIO_MEMBER_MAIN, self::SCENARIO_MEMBERS_UNIVERSITIES
        ])) {
            /** @var MemberMain $member */
            $this->is_plans_live_in_city = $member->is_plans_live_in_city;
            $this->address_live_in_city = $member->address_live_in_city;
        }

        // Заполнение поля статус
        if (in_array($this->scenario, [
            self::SCENARIO_TECHNICAL_STAFF,
            self::SCENARIO_SECURITY_SERVICE,
            self::SCENARIO_PARTNERS,
            self::SCENARIO_PRESS,
            self::SCENARIO_MODERATORS,
            self::SCENARIO_GUESTS,
            self::SCENARIO_JURY,
            self::SCENARIO_VOLUNTEERS,
            self::SCENARIO_MANAGEMENT,
        ])) {
            /** @var BaseMemberTechnicalStaff $member */
            $this->status = $member->status;
        }

        // Заполнение поля название организации
        if (in_array($this->scenario, [
            self::SCENARIO_PARTNERS,
            self::SCENARIO_PRESS,
        ])) {
            /** @var BaseMemberPartners $member */
            $this->name_organization = $member->name_organization;
        }

        // Заполнение поля номинация
        if (in_array($this->scenario, [
            self::SCENARIO_JURY,
        ])) {
            /** @var BaseMemberJury $member */
            $this->nomination_id = $member->nomination_id;
        }

        // Заполнение поелй должность и место работы
        if (in_array($this->scenario, [
            self::SCENARIO_GUESTS,
            self::SCENARIO_JURY,
        ])) {
            /** @var BaseMemberGuests $member */
            $this->place_work = $member->place_work;
            $this->position = $member->position;
        }

        // Заполнение полей ФИО ответственного лица и Телефон ответственного лица
        if (in_array($this->scenario, [
            self::SCENARIO_MEMBERS_PUPILS,
        ])) {
            /** @var BaseMemberPupils $member */
            $this->agent_fio = $member->agent_fio;
            $this->agent_phone = $member->agent_phone;
        }
    }
}