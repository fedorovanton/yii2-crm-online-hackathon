<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 26/09/2019
 * Time: 09:35
 */

namespace backend\components;

use common\components\Role;
use common\models\MemberTechnicalStaff\BaseMemberTechnicalStaff;
use common\models\NominationTeam\BaseNominationTeam;
use common\models\User;
use frontend\models\MemberInfo\MemberInfo;
use frontend\models\Team\Team;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Response;

/**
 * Класс для экспорта данных для раздела Экспорт
 *
 * Class ExportHelper
 * @package backend\components
 */
class ExportInFile
{
    /** @var $data array */
    public $data;

    /** @var Spreadsheet $spreadsheet */
    public $spreadsheet;

    /**
     * @inheritdoc
     * ExportInFile constructor.
     * @param $data
     */
    public function __construct()
    {
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        $this->spreadsheet = new Spreadsheet();
    }

    /**
     * Сохранение сформированного файла
     * @return $this
     */
    private function _save()
    {
        $writer = IOFactory::createWriter($this->spreadsheet, "Xlsx");
        $tmpResource = tmpfile();
        $tmpResourceMetaData = stream_get_meta_data($tmpResource);
        $tmpFileName = $tmpResourceMetaData['uri'];
//        $tmpFileName = Yii::getAlias('@backend').'/export/export_'.date('y-m-d__H_i').'.xlsx';
        $writer->save($tmpFileName);
        $response = Yii::$app->getResponse();
        unset($writer);
        $tmpFileStatistics = fstat($tmpResource);
        if ($tmpFileStatistics['size'] > 0) {
            return Yii::$app->getResponse()->sendStreamAsFile($tmpResource, 'export_'.date('y-m-d_H:i').'.xlsx', []);
        }
        $response->on(Response::EVENT_AFTER_SEND, function() use ($tmpResource) {
            fclose($tmpResource);
        });
        return $response->sendFile($tmpFileName, 'export_'.date('y-m-d_H:i').'.xlsx', []);
    }

    private function _prependShift($num_sheet, $member_role)
    {
        $myWorkSheet = new Worksheet($this->spreadsheet, User::getRoleName($member_role));
        $this->spreadsheet->addSheet($myWorkSheet, $num_sheet);
        $sheet = $this->spreadsheet->getSheet($num_sheet);
        return $sheet;
    }

    /**
     * @param $sheet
     * @param $arrayData
     */
    private function _appendShift($sheet, $arrayData)
    {
        /** @var $sheet Worksheet */
        $sheet->fromArray($arrayData, NULL, 'A1');
        $nCols = count($arrayData[0]);
        foreach (range(0, $nCols) as $col) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }
    }


    /**
     * Заполнение листа - Технический персонал
     * @param $num_sheet
     * @param $member_role
     */
    private function _fillTechnicalStaffSheet($num_sheet, $member_role)
    {
        $sheet = $this->_prependShift($num_sheet, $member_role);

        $arrayData = [
            [
                'ID',
                'ФИО',
                'Телефон',
                'Статус'
            ]
        ];

        if (!empty($this->data[$member_role])) {
            foreach ($this->data[$member_role] as $member) {
                $arrayData[] = [
                    $member['id'],
                    $member['fio'],
                    $member['phone'],
                    $member['status'],
                ];
            }
        }

        $this->_appendShift($sheet, $arrayData);
    }

    /**
     * Заполнение листа - Служба безопасности
     * @param $num_sheet
     * @param $member_role
     */
    private function _fillSecurityServiceSheet($num_sheet, $member_role)
    {
        $sheet = $this->_prependShift($num_sheet, $member_role);

        $arrayData = [
            [
                'ID',
                'ФИО',
                'Телефон',
                'Статус'
            ]
        ];

        if (!empty($this->data[$member_role])) {
            foreach ($this->data[$member_role] as $member) {
                $arrayData[] = [
                    $member['id'],
                    $member['fio'],
                    $member['phone'],
                    $member['status'],
                ];
            }
        }

        $this->_appendShift($sheet, $arrayData);
    }

    /**
     * Заполнение листа - Партнеры
     * @param $num_sheet
     * @param $member_role
     */
    private function _fillPartnersSheet($num_sheet, $member_role)
    {
        $sheet = $this->_prependShift($num_sheet, $member_role);

        $arrayData = [
            [
                'ID',
                'ФИО',
                'Email',
                'Телефон',
                'Название организации',
                'Статус',
            ]
        ];

        if (!empty($this->data[$member_role])) {
            foreach ($this->data[$member_role] as $member) {
                $arrayData[] = [
                    $member['id'],
                    $member['fio'],
                    $member['email'],
                    $member['phone'],
                    $member['name_organization'],
                    $member['status'],
                ];
            }
        }

        $this->_appendShift($sheet, $arrayData);
    }

    /**
     * Заполнение листа - Пресса
     * @param $num_sheet
     * @param $member_role
     */
    private function _fillPressSheet($num_sheet, $member_role)
    {
        $sheet = $this->_prependShift($num_sheet, $member_role);

        $arrayData = [
            [
                'ID',
                'ФИО',
                'Email',
                'Телефон',
                'Название организации',
                'Статус',
            ]
        ];

        if (!empty($this->data[$member_role])) {
            foreach ($this->data[$member_role] as $member) {
                $arrayData[] = [
                    $member['id'],
                    $member['fio'],
                    $member['email'],
                    $member['phone'],
                    $member['name_organization'],
                    $member['status'],
                ];
            }
        }

        $this->_appendShift($sheet, $arrayData);
    }

    /**
     * Заполнение листа - Модераторы
     * @param $num_sheet
     * @param $member_role
     */
    private function _fillModeratorsSheet($num_sheet, $member_role)
    {
        $sheet = $this->_prependShift($num_sheet, $member_role);

        $arrayData = [
            [
                'ID',
                'ФИО',
                'Email',
                'Телефон',
                'Статус',
            ]
        ];

        if (!empty($this->data[$member_role])) {
            foreach ($this->data[$member_role] as $member) {
                $arrayData[] = [
                    $member['id'],
                    $member['fio'],
                    $member['email'],
                    $member['phone'],
                    $member['status'],
                ];
            }
        }

        $this->_appendShift($sheet, $arrayData);
    }

    /**
     * Заполнение листа - Гости и почетные гости
     * @param $num_sheet
     * @param $member_role
     */
    private function _fillGuestSheet($num_sheet, $member_role)
    {
        $sheet = $this->_prependShift($num_sheet, $member_role);

        $arrayData = [
            [
                'Номер',
                'ФИО',
                'Email',
                'Телефон',
                'Место работы',
                'Должность',
                'Статус',
            ]
        ];

        if (!empty($this->data[$member_role])) {
            foreach ($this->data[$member_role] as $member) {
                $arrayData[] = [
                    $member['id'],
                    $member['fio'],
                    $member['email'],
                    $member['phone'],
                    $member['place_work'],
                    $member['position'],
                    $member['status'],
                ];
            }
        }

        $this->_appendShift($sheet, $arrayData);
    }

    /**
     * Заполнение листа - Жюри и эксперты
     * @param $num_sheet
     * @param $member_role
     */
    private function _fillJurySheet($num_sheet, $member_role)
    {
        $sheet = $this->_prependShift($num_sheet, $member_role);

        $arrayData = [
            [
                'Номер',
                'ФИО',
                'Email',
                'Телефон',
                'Место работы',
                'Должность',
                'Статус',
            ]
        ];

        if (!empty($this->data[$member_role])) {
            foreach ($this->data[$member_role] as $member) {
                $arrayData[] = [
                    $member['id'],
                    $member['fio'],
                    $member['email'],
                    $member['phone'],
                    $member['place_work'],
                    $member['position'],
                    $member['status'],
                ];
            }
        }

        $this->_appendShift($sheet, $arrayData);
    }

    /**
     * Заполнение листа - Волонтенры
     * @param $num_sheet
     * @param $member_role
     */
    private function _fillVolunteersSheet($num_sheet, $member_role)
    {
        $sheet = $this->_prependShift($num_sheet, $member_role);

        $arrayData = [
            [
                'Номер',
                'ФИО',
                'Email',
                'Телефон',
                'Статус',
            ]
        ];
        if (!empty($this->data[$member_role])) {
            foreach ($this->data[$member_role] as $member) {
                $arrayData[] = [
                    $member['id'],
                    $member['fio'],
                    $member['email'],
                    $member['phone'],
                    $member['status'],
                ];
            }
        }

        $this->_appendShift($sheet, $arrayData);
    }

    /**
     * Заполнение листа - Дирекция и организаторы
     * @param $num_sheet
     * @param $member_role
     */
    private function _fillManagementSheet($num_sheet, $member_role)
    {
        $sheet = $this->_prependShift($num_sheet, $member_role);

        $arrayData = [
            [
                'Номер',
                'ФИО',
                'Email',
                'Телефон',
                'Сбор',
                'Статус',
            ]
        ];

        if (!empty($this->data[$member_role])) {
            foreach ($this->data[$member_role] as $member) {
                $arrayData[] = [
                    $member['id'],
                    $member['fio'],
                    $member['email'],
                    $member['phone'],
                    $member['status'],
                ];
            }
        }

        $this->_appendShift($sheet, $arrayData);
    }

    /**
     * Заполнение листа - Участники (основные)
     * @param $num_sheet
     * @param $member_role
     */
    private function _fillMemberMainSheet($num_sheet, $member_role)
    {
        $sheet = $this->_prependShift($num_sheet, $member_role);

        $arrayData = [
            [
                'Номер',
                'ФИО',
                'Email',
                'Телефон',
                'Регион проживания',
                'Номинация',
                'Статус участника',
                'Команда',
                'Приоритет 1',
                'Приоритет 2',
                'Приоритет 3',
                'Сбор',
                'Верификация по SMS',
                'Статус анкеты',
                'Файл загружен',
                'Ссылка на файл',
            ]
        ];

        if (!empty($this->data[$member_role])) {
            foreach ($this->data[$member_role] as $member) {
                $arrayData[] = [
                    $member['id'],
                    $member['fio'],
                    $member['email'],
                    $member['phone'],
                    $member['region_residence'],
                    $member['nomination'],
                    $member['team_status'],
                    $member['team'],
                    $member['priority_1'],
                    $member['priority_2'],
                    $member['priority_3'],
                    $member['isAssembled'],
                    $member['sms_verification'],
                    $member['check_status'],
                    $member['isFileUploaded'],
                    $member['file'],
                ];
            }
        }

        $this->_appendShift($sheet, $arrayData);
    }

    /**
     * Заполнение листа - Участники (вузы)
     * @param $num_sheet
     * @param $member_role
     */
    private function _fillMemberUniversitiesSheet($num_sheet, $member_role)
    {
        $sheet = $this->_prependShift($num_sheet, $member_role);

        $arrayData = [
            [
                'Номер',
                'ФИО',
                'Email',
                'Телефон',
                'Университет',
                'Регион проживания',
                'Номинация',
                'Статус участника',
                'Команда',
                'Сбор',
                'Статус анкеты',
                'Файл загружен',
                'Ссылка на файл'
            ]
        ];

        if (!empty($this->data[$member_role])) {
            foreach ($this->data[$member_role] as $member) {
                $arrayData[] = [
                    $member['id'],
                    $member['fio'],
                    $member['email'],
                    $member['phone'],
                    $member['description'],
                    $member['region_residence'],
                    $member['nomination'],
                    $member['team_status'],
                    $member['team'],
                    $member['isAssembled'],
                    $member['check_status'],
                    $member['isFileUploaded'],
                    $member['file'],
                ];
            }
        }

        $this->_appendShift($sheet, $arrayData);
    }

    /**
     * Заполнение листа - Участники (школьники)
     * @param $num_sheet
     * @param $member_role
     */
    private function _fillMemberPupilsSheet($num_sheet, $member_role)
    {
        $sheet = $this->_prependShift($num_sheet, $member_role);

        $arrayData = [
            [
                'Номер',
                'ФИО',
                'Email',
                'Телефон',
                'Регион проживания',
                'Номинация',
                'Статус участника',
                'Команда',
                'Сбор',
                'Статус анкеты',
                'Файл загружен',
                'Ссылка на файл'
            ]
        ];

        if (!empty($this->data[$member_role])) {
            foreach ($this->data[$member_role] as $member) {
                $arrayData[] = [
                    $member['id'],
                    $member['fio'],
                    $member['email'],
                    $member['phone'],
                    $member['region_residence'],
                    $member['nomination'],
                    $member['team_status'],
                    $member['team'],
                    $member['isAssembled'],
                    $member['check_status'],
                    $member['isFileUploaded'],
                    $member['file'],
                ];
            }
        }

        $this->_appendShift($sheet, $arrayData);
    }

    /**
     * Заполнение таблицы
     */
    private function _fillAllSheet()
    {
        $this->_fillMemberMainSheet(0, Role::MEMBERS_MAIN);
        $this->_fillMemberUniversitiesSheet(1, Role::MEMBERS_UNIVERSITIES);
        $this->_fillMemberPupilsSheet(2, Role::MEMBERS_PUPILS);
        $this->_fillManagementSheet(3, Role::MANAGEMENT);
        $this->_fillVolunteersSheet(4, Role::VOLUNTEERS);
        $this->_fillJurySheet(5, Role::JURY);
        $this->_fillGuestSheet(6, Role::GUESTS);
        $this->_fillModeratorsSheet(7, Role::MODERATORS);
        $this->_fillPressSheet(8, Role::PRESS);
        $this->_fillPartnersSheet(9, Role::PARTNERS);
        $this->_fillSecurityServiceSheet(10, Role::SECURITY_SERVICE);
        $this->_fillTechnicalStaffSheet(11, Role::TECHNICAL_STAFF);
    }

    /**
     * Подготовка данных - Технический персонал
     *
     * @param $role
     * @param $member
     */
    private function _memberTechnicalStaff($role, $member)
    {
        /** @var MemberInfo $member */
        $this->data[$role][] = [
            'id' => $member->badge_number,
            'fio' => $member->getFullName(),
            'phone' => $member->phone,
            'status' => User::getRoleName($role),
        ];
    }

    /**
     * Подготовка данных - Служба безопасности
     *
     * @param $role
     * @param $member
     */
    private function _memberSecurityService($role, $member)
    {
        /** @var MemberInfo $member */
        $this->data[$role][] = [
            'id' => $member->badge_number,
            'fio' => $member->getFullName(),
            'phone' => $member->phone,
            'status' => User::getRoleName($role),
        ];
    }

    /**
     * Подготовка данных - Партнеры
     *
     * @param $role
     * @param $member
     */
    private function _memberPartners($role, $member)
    {
        /** @var MemberInfo $member */
        $this->data[$role][] = [
            'id' => $member->badge_number,
            'fio' => $member->getFullName(),
            'email' => $member->email,
            'phone' => $member->phone,
            'name_organization' => $member->memberPartners->name_organization,
            'status' => User::getRoleName($role),
        ];
    }

    /**
     * Подготовка данных - Пресса
     *
     * @param $role
     * @param $member
     */
    private function _memberPress($role, $member)
    {
        /** @var MemberInfo $member */
        $this->data[$role][] = [
            'id' => $member->badge_number,
            'fio' => $member->getFullName(),
            'email' => $member->email,
            'phone' => $member->phone,
            'name_organization' => $member->memberPress->name_organization,
            'status' => User::getRoleName($role),
        ];
    }

    /**
     * Подготовка данных - Модераторы
     *
     * @param $role
     * @param $member
     */
    private function _memberModerators($role, $member)
    {
        /** @var MemberInfo $member */
        $this->data[$role][] = [
            'id' => $member->badge_number,
            'fio' => $member->getFullName(),
            'email' => $member->email,
            'phone' => $member->phone,
            'status' => User::getRoleName($role),
        ];
    }

    /**
     * Подготовка данных - Гости и почетные гости
     *
     * @param $role
     * @param $member
     */
    private function _memberGuest($role, $member)
    {
        /** @var MemberInfo $member */
        $this->data[$role][] = [
            'id' => $member->badge_number,
            'fio' => $member->getFullName(),
            'email' => $member->email,
            'phone' => $member->phone,
            'place_work' => $member->memberGuests->place_work,
            'position' => $member->memberGuests->position,
            'status' => $member->memberGuests->getStatusValue(),
        ];
    }

    /**
     * Подготовка данных - Жюри и эксперты
     *
     * @param $role
     * @param $member
     */
    private function _memberJury($role, $member)
    {
        /** @var MemberInfo $member */
        $this->data[$role][] = [
            'id' => $member->badge_number,
            'fio' => $member->getFullName(),
            'email' => $member->email,
            'phone' => $member->phone,
            'place_work' => $member->memberJury->place_work,
            'position' => $member->memberJury->position,
            'status' => $member->memberJury->getStatusValue(),
        ];
    }

    /**
     * Подготовка данных - Волонтеры
     *
     * @param $role
     * @param $member
     */
    private function _memberVolunteers($role, $member)
    {
        /** @var MemberInfo $member */
        $this->data[$role][] = [
            'id' => $member->badge_number,
            'fio' => $member->getFullName(),
            'email' => $member->email,
            'phone' => $member->phone,
            'status' => User::getRoleName($role),
        ];
    }

    /**
     * Подготовка данных - Дирекция и организаторы
     *
     * @param $role
     * @param $member
     */
    private function _memberManagement($role, $member)
    {
        /** @var MemberInfo $member */
        $this->data[$role][] = [
            'id' => $member->badge_number,
            'fio' => $member->getFullName(),
            'email' => $member->email,
            'phone' => $member->phone,
            'status' => $member->memberManagement->getStatusValue(),
        ];
    }

    /**
     * Подготовка данных - Участники (школьники)
     *
     * @param $role
     * @param $member
     */
    private function _memberPupils($role, $member)
    {
        /** @var MemberInfo $member */
        $this->data[$role][] = [
            'id' => $member->badge_number,
            'fio' => $member->getFullName(),
            'email' => $member->email,
            'phone' => $member->phone,
            'region_residence' => $member->memberPupils->region_residence,
            'nomination' => $member->memberPupils->getFinalNomination(),
            'team_status' => $member->memberPupils->getTeamStatusName(),
            'team' => (isset($member->memberPupils->team)) ? $member->memberPupils->team->name : 'Нет команды',
            'isAssembled' => (isset($member->memberPupils->team)) ? $member->memberPupils->team->isAssembled($role) : 'Не определено',
            'check_status' => $member->getCheckStatusValue(),
            'isFileUploaded' => (empty($member->memberPupils->doc_file)) ? 'Нет' : 'Да',
            'file' => (empty($member->memberPupils->doc_file)) ? null : 'https://admin.cproriv.ru/uploads/members-doc-file/'.$member->memberPupils->doc_file
        ];
    }

    /**
     * Подготовка данных - Участники (студенты)
     *
     * @param $role
     * @param $member
     */
    private function _memberUniversities($role, $member)
    {
        /** @var MemberInfo $member */
        $this->data[$role][] = [
            'id' => $member->badge_number,
            'fio' => $member->getFullName(),
            'email' => $member->email,
            'phone' => $member->phone,
            'description' => $member->user->description,
            'region_residence' => $member->memberUniversities->region_residence,
            'nomination' => $member->memberUniversities->getFinalNomination(),
            'team_status' => $member->memberUniversities->getTeamStatusName(),
            'team' => (isset($member->memberUniversities->team)) ? $member->memberUniversities->team->name : 'Нет команды',
            'isAssembled' => (isset($member->memberUniversities->team)) ? $member->memberUniversities->team->isAssembled($role) : 'Не определено',
            'check_status' => $member->getCheckStatusValue(),
            'isFileUploaded' => (empty($member->memberUniversities->doc_file)) ? 'Нет' : 'Да',
            'file' => (empty($member->memberUniversities->doc_file)) ? null : 'https://admin.cproriv.ru/uploads/members-doc-file/'.$member->memberUniversities->doc_file
        ];
    }

    /**
     * Подготовка данных - Участники (основные)
     *
     * @param $role
     * @param $member
     */
    private function _memberMain($role, $member)
    {
        /** @var MemberInfo $member */
        $this->data[$role][] = [
            'id' => $member->badge_number,
            'fio' => $member->getFullName(),
            'email' => $member->email,
            'phone' => $member->phone,
            'region_residence' => $member->memberMain->region_residence,
            'nomination' => $member->memberMain->getFinalNomination(),
            'team_status' => $member->memberMain->getTeamStatusName(),
            'team' => (isset($member->memberMain->team)) ? $member->memberMain->team->name : 'Нет команды',
            'priority_1' => (isset($member->memberMain->team)) ? $member->memberMain->team->getNominationTeamByPriority(BaseNominationTeam::PRIORITY_1) : 'Не определено',
            'priority_2' => (isset($member->memberMain->team)) ? $member->memberMain->team->getNominationTeamByPriority(BaseNominationTeam::PRIORITY_2) : 'Не определено',
            'priority_3' => (isset($member->memberMain->team)) ? $member->memberMain->team->getNominationTeamByPriority(BaseNominationTeam::PRIORITY_2) : 'Не определено',
            'isAssembled' => (isset($member->memberMain->team)) ? $member->memberMain->team->isAssembled($role) : 'Не определено',
            'sms_verification' => ($member->isValidSmsCode == MemberInfo::IS_VALID_SMS_CODE) ? 'Подтвержден' : 'Не подтвержден',
            'check_status' => $member->getCheckStatusValue(),
            'isFileUploaded' => (empty($member->memberMain->doc_file)) ? 'Нет' : 'Да',
            'file' => (empty($member->memberMain->doc_file)) ? null : 'https://admin.cproriv.ru/uploads/members-doc-file/'.$member->memberMain->doc_file,
        ];
    }

    /**
     * Заполнить массив с данными конкретными участниками
     * @param $role
     */
    private function _getMemberData($role)
    {
        $members__batch = MemberInfo::find()
            ->where(['member_form_scenario' => $role])
            ->batch();

        foreach ($members__batch as $members) {
            foreach ($members as $member) {
                switch ($role) {
                    case Role::TECHNICAL_STAFF: $this->_memberTechnicalStaff($role, $member); break;
                    case Role::SECURITY_SERVICE: $this->_memberSecurityService($role, $member); break;
                    case Role::PARTNERS: $this->_memberPartners($role, $member); break;
                    case Role::PRESS: $this->_memberPress($role, $member); break;
                    case Role::MODERATORS: $this->_memberModerators($role, $member); break;
                    case Role::GUESTS: $this->_memberGuest($role, $member); break;
                    case Role::JURY: $this->_memberJury($role, $member); break;
                    case Role::VOLUNTEERS: $this->_memberVolunteers($role, $member); break;
                    case Role::MANAGEMENT: $this->_memberManagement($role, $member); break;
                    case Role::MEMBERS_PUPILS: $this->_memberPupils($role, $member); break;
                    case Role::MEMBERS_UNIVERSITIES: $this->_memberUniversities($role, $member); break;
                    case Role::MEMBERS_MAIN: $this->_memberMain($role, $member); break;
                }
            }
        }
    }

    /**
     * Подготовка всех данных
     */
    private function _getAllData()
    {
        $this->_getMemberData(Role::MEMBERS_MAIN);
        $this->_getMemberData(Role::MEMBERS_UNIVERSITIES);
        $this->_getMemberData(Role::MEMBERS_PUPILS);
        $this->_getMemberData(Role::MANAGEMENT);
        $this->_getMemberData(Role::VOLUNTEERS);
        $this->_getMemberData(Role::JURY);
        $this->_getMemberData(Role::GUESTS);
        $this->_getMemberData(Role::MODERATORS);
        $this->_getMemberData(Role::PRESS);
        $this->_getMemberData(Role::PARTNERS);
        $this->_getMemberData(Role::SECURITY_SERVICE);
        $this->_getMemberData(Role::TECHNICAL_STAFF);
    }

    /**
     * Запуск Экспортировать общий список участников и организаторов в xls
     */
    public function run()
    {
        // Получение всех данных
        $this->_getAllData();

        // Заполнение таблицы
        $this->_fillAllSheet();

        // Сохранение таблицы в файл
        $this->_save();
    }

    /**
     * Запуск Экспортировать список команд с номинациями в xls
     */
    public function runTeamNomination()
    {
        $teams__batch = Team::find()
            ->where(['user_create_role' => Role::MEMBERS_MAIN])
            ->batch(50);

        foreach ($teams__batch as $teams) {
            foreach ($teams as $team) {
                /** @var Team $team */
                $this->data[Role::MEMBERS_MAIN][] = [
                    'name' => $team->name,
                    'cnt' => $team->countMembersMainInTeam(),
                    'priority_1' => $team->getNominationTeamByPriority(BaseNominationTeam::PRIORITY_1),
                    'priority_2' => $team->getNominationTeamByPriority(BaseNominationTeam::PRIORITY_2),
                    'priority_3' => $team->getNominationTeamByPriority(BaseNominationTeam::PRIORITY_3),
                ];
            }
        }

        $sheet = $this->_prependShift(0, Role::MEMBERS_MAIN);

        $arrayData = [
            [
                'Название команды',
                'Количество человек',
                'Приоритет 1',
                'Приоритет 2',
                'Приоритет 3',
            ]
        ];

        foreach ($this->data[Role::MEMBERS_MAIN] as $member) {
            $arrayData[] = [
                $member['name'],
                $member['cnt'],
                $member['priority_1'],
                $member['priority_2'],
                $member['priority_3'],
            ];
        }

        $this->_appendShift($sheet, $arrayData);

        $this->_save();
    }
}