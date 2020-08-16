<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 16/09/2019
 * Time: 09:27
 */

namespace frontend\forms;


use frontend\models\MemberInfo\MemberInfo;
use frontend\models\MemberMain\MemberMain;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use Yii;


/**
 * Форма для заполнения анкеты основного участника в публичной доступе
 *
 * Class MemberMainPublicForm
 * @property $id integer
 * @property $docFile string
 * @property $last_name string
 * @property $first_name string
 * @property $second_name string
 * @property $missing_second_name string
 * @property $phone string
 * @property $email string
 * @property $clothing_size string
 * @property $region_residence string
 * @property $team_status string
 * @property $is_plans_live_in_city string
 * @property $address_live_in_city string
 * @property $badge_number string
 * @property $accept string
 * @package frontend\models\MemberMain
 */
class MemberMainPublicForm extends Model
{
    public $id;
    public $docFile;
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

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            // Идентификатор
            ['id', 'integer'],

            // Документ
            ['docFile',
                'file',
                'skipOnEmpty' => false,
                'extensions' => 'doc, docx, pdf, png, jpg, jpeg, DOC, DOCX, PDF, PNG, JPG, JPEG',
            ],

            // Фамилия
            ['last_name', 'string', 'max' => 80],

            // Имя
            ['first_name', 'string', 'max' => 80],

            // Отчество
            /*['second_name', 'required',
                'when' => function($model) {
                    return $model->missing_second_name == false;
                },
                'message' => 'Необходимо заполнить отчество, если оно у вас есть.'
            ],*/
            ['second_name', 'string', 'max' => 80],

            // Нет отчество
            ['missing_second_name', 'boolean'],

            // Телефон
            ['phone', 'string', 'max' => 20],

            // Email
            ['email', 'string', 'max' => 50],

            // Размер одежды
            ['clothing_size', 'string', 'max' => 1024],

            // Регион проживания
            ['region_residence', 'string', 'max' => 255],

            // Статус в команде
            ['team_status', 'integer'],

            // Планируете ли проживать в г. Казань
            ['is_plans_live_in_city', 'required', 'message' => 'Вы должны указать будете ли проживать в г.Казань?'],
            ['is_plans_live_in_city', 'string', 'skipOnEmpty' => false, 'max' => 3],

            // Адрес проживания в г. Казань
            ['address_live_in_city', 'required',
                'when' => function($model) {
                    return $model->is_plans_live_in_city == MemberMain::IS_LIVE_IN_KASAN;
                },
                'whenClient' => "function (attribute, value) {
                    return $('#memberform-is_plans_live_in_city').val() == 'Да';
                }",
                'message' => 'Вы должны указать адрес проживания в г.Казань.'
            ],
            ['address_live_in_city', 'string', 'max' => 255],

            // Номер бейджа
            ['badge_number', 'string', 'max' => 4],

            // Согласен на обработку данных
            ['accept', 'compare', 'compareValue' => 1, 'message' => 'Вы должны подтвердить согласие на обработку персональных данных.'],
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID инфо участника',
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'second_name' => 'Отчество',
            'phone' => 'Телефон',
            'email' => 'Email',
            'clothing_size' => 'Размер одежды',
            'region_residence' => 'Регион проживания',
            'team_status' => 'Статус в команде',
            'is_plans_live_in_city' => 'Планируете ли проживать в г. Казань',
            'address_live_in_city' => 'Адрес проживания в г. Казань',
            'badge_number' => 'Номер бейджа',
            'docFile' => 'Резюме',
            'accept' => 'Я согласен(-а) на обработку данных',
        ];
    }

    /**
     * Заполнить поля формы данными из моделей
     * @param MemberInfo $member
     */
    public function fillForm(MemberInfo $member)
    {
        $this->id = $member->id;
        $this->last_name = $member->last_name;
        $this->first_name = $member->first_name;
        $this->second_name = $member->second_name;
        $this->phone = $member->phone;
        $this->email = $member->email;
        $this->badge_number = $member->badge_number;

        $this->clothing_size = $member->memberMain->clothing_size;
        $this->region_residence = $member->memberMain->region_residence;
        $this->team_status = $member->memberMain->team_status;
        $this->is_plans_live_in_city = $member->memberMain->is_plans_live_in_city;
        $this->address_live_in_city = $member->memberMain->address_live_in_city;
        $this->docFile = $member->memberMain->doc_file;
    }

    /**
     * Сервис обновления данными из формы в разных моделях
     */
    public function updateDataInModels()
    {
        /** @var MemberInfo $member */
        $member = MemberInfo::findMemberById($this->id);

        if ($member) {

            $member->setUpdated();
            $member->update();

            $member->memberMain->setIsPlansLiveInCity($this->is_plans_live_in_city);
            $member->memberMain->setAddressLiveInCity($this->address_live_in_city);
            if ($this->docFile) {
                $member->memberMain->doc_file = $member->memberMain->upload($this);
            }
            $member->memberMain->setUpdated();
            $member->memberMain->update();
        }
    }
}