<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 18:32
 */

namespace console\controllers;


use common\components\Role;
use common\models\MemberGuests\BaseMemberGuests;
use common\models\MemberManagement\BaseMemberManagement;
use common\models\MemberPartners\BaseMemberPartners;
use common\models\MemberPupils\BaseMemberPupils;
use common\models\MemberTechnicalStaff\BaseMemberTechnicalStaff;
use frontend\forms\MemberForm;
use frontend\models\MemberInfo\MemberInfo;
use frontend\models\MemberMain\MemberMain;
use frontend\models\Team\Team;
use moonland\phpexcel\Excel;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii\helpers\VarDumper;

/**
 * Консольный контроллер для участников
 *
 * Class MemberController
 * @package console\controllers
 */
class MemberController extends Controller
{
    /** @var $member_main string Опция - Импортировать xls файл для основных участников */
    public $member_main;

    /** @var $member_pupils string Опция - Импортировать xls файл для участников - школьникки */
    public $member_pupils;

    /** @var $member_guest string Опция - Импортировать xls файл для гостей и почетных гостей */
    public $member_guest;

    /** @var $member_management string Опция - Импортировать xls файл для организаторов и дирекции */
    public $member_management;

    /** @var $member_partners string Опция - Импортировать xls файл для партнеров */
    public $member_partners;

    /** @var $member_technical_staff string Опция - Импортировать xls файл для технического персонала */
    public $member_technical_staff;

    /**
     * Описываем возможные опции (--option)
     * @param string $actionID
     * @return array
     */
    public function options($actionID)
    {
        return [
            'member_main',
            'member_pupils',
            'member_guest',
            'member_management',
            'member_partners',
            'member_technical_staff',
        ];
    }

    /**
     * Меняет символы кириллицу на латиницу
     * P.S. была ошибка в размере одежде. Буква М была русской
     * @param $size
     * @return string
     */
    private static function _changeChar($size)
    {

        switch ($size) {
            case 'М': return 'M';
            case '44': return 'XS';
            case '46': return 'S';
            case '48': return 'M';
            case '50': return 'L';
            case '52': return 'XL';
            case '54':
            case '55':
            case '56':
                return 'XXL';
            case '58':
            case '59':
            case '60':
                return 'XXXL';
            case '64': return 'XXXL'; // для этого размера нет размерного ряда
            default:
                return $size;
        }
    }

    /**
     * Поменять название команды на адекватное
     * @param $name_team
     * @return string
     */
    private static function _changeNameTeam($name_team)
    {
        $name_team = (string)$name_team;

        switch ($name_team) {
            case 'NΣW ÇØᗞÎƝǤ ℂÜŁTᙀᖇΞ': return 'NEW CODING CULTURE';
            default: return $name_team;
        }
    }

    /**
     * Обработка для файла основных участников
     * @param $data
     * @return int
     */
    private function _processMemberMain($data)
    {
        if (!empty($data)) {
            /** @var array $data */
            foreach ($data as $line) {
                if (!empty($line['Фамилия'])) {
                    $member_info = new MemberInfo();
                    $member_info->setLastName($line['Фамилия']);
                    $member_info->setFirstName($line['Имя']);
                    $member_info->setSecondName($line['Отчество']);
                    $member_info->setPhone($line['Телефон']);
                    $member_info->setEmail($line['Еmail']);
                    $member_info->setMemberFormScenario(MemberForm::SCENARIO_MEMBER_MAIN);
                    $member_info->setCreated();
                    $member_info->setUpdated();
                    if (!$member_info->save()) {
                        VarDumper::dump($line, 10, true);
                        VarDumper::dump($member_info->errors, 10, true);
                        return ExitCode::UNSPECIFIED_ERROR;
                    } else {
                        $member_info->saveBadgeNumber(); // Сгененрировать и сохранить номер бейджа
                    }

                    $team = Team::findByName($line['Команда']);
                    if (empty($team)) {
                        $team = new Team();
                        $team->setName(self::_changeNameTeam($line['Команда']));
                        $team->setCityRegionalStage($line['Город проведения']);
                        $team->setCreated();
                        $team->setUserCreateRole(Role::MEMBERS_MAIN);
                        $team->setUpdated();
                        if (!$team->save()) {
                            $team_id = null;
                        } else {
                            $team_id = $team->id;
                        }
                    } else {
                        $team_id = $team->id;
                    }

                    $member = new MemberMain();
                    $member->setClothingSize(self::_changeChar($line['Размер толстовки']));
//                    $member->setTeamStatus($line['Капитан/Участник']);
                    $member->setTeamStatus(MemberMain::TEAM_STATUS_MEMBER);
                    $member->setTeamId($team_id);
                    $member->setRegionResidence($line['Регион проживания']);
                    $member->setMemberInfoId($member_info->id);
                    $member->setCreated();
                    $member->setUpdated();
                    if (!$member->save()) {
                        VarDumper::dump($line, 10, true);
                        VarDumper::dump($member->errors, 10, true);
                        return ExitCode::UNSPECIFIED_ERROR;
                    }
                }
            }
        }
    }

    /**
     * Обработка для файла  участников-школьников
     * @param $data
     * @return int
     */
    private function _processMemberPupils($data)
    {
        if (!empty($data)) {
            /** @var array $data */
            foreach ($data as $line) {
                if (!empty($line['Фамилия'])) {
                    $member_info = new MemberInfo();
                    $member_info->setLastName($line['Фамилия']);
                    $member_info->setFirstName($line['Имя']);
                    $member_info->setSecondName($line['Отчество']);
                    if (empty($line['Телефон'])) {
                        $member_info->setPhone('');
                    } else {
                        $member_info->setPhone($line['Телефон']);
                    }
                    $member_info->setEmail($line['E-mail']);
                    $member_info->setMemberFormScenario(MemberForm::SCENARIO_MEMBERS_PUPILS);
                    $member_info->setUserId($line['ID пользователя']);
                    $member_info->setCreated();
                    $member_info->setUpdated();
                    if (!$member_info->save()) {
                        VarDumper::dump($line, 10, true);
                        VarDumper::dump($member_info->errors, 10, true);
                        return ExitCode::UNSPECIFIED_ERROR;
                    } else {
                        $member_info->saveBadgeNumber(); // Сгененрировать и сохранить номер бейджа
                    }

                    $team = Team::findByNameAndUserId($line['Команда'], $line['ID пользователя']);
                    if (empty($team)) {
                        $team = new Team();
                        $team->setName(self::_changeNameTeam($line['Команда']));
                        $team->setCreated();
                        $team->setUserCreateRole(Role::MEMBERS_PUPILS);
                        $team->setUserId($line['ID пользователя']);
                        $team->setUpdated();
                        if (!$team->save()) {
                            $team_id = null;
                        } else {
                            $team_id = $team->id;
                        }
                    } else {
                        $team_id = $team->id;
                    }

                    $member = new BaseMemberPupils();
                    if ($line['Капитан/Участник'] == 'Капитан') {
                        $team_status = BaseMemberPupils::TEAM_STATUS_CAPTAIN;
                    } else {
                        $team_status = BaseMemberPupils::TEAM_STATUS_MEMBER;
                    }
                    $member->setTeamStatus($team_status);
                    $member->setTeamId($team_id);
                    $member->setRegionResidence($line['Регион проживания']);
                    $member->setMemberInfoId($member_info->id);
                    $member->setCreated();
                    $member->setUpdated();
                    if (!$member->save()) {
                        VarDumper::dump($line, 10, true);
                        VarDumper::dump($member->errors, 10, true);
                        return ExitCode::UNSPECIFIED_ERROR;
                    }
                }
            }
        }
    }

    /**
     * Обработка для файл гостей и почетных гостей
     * @param $data
     * @return int
     */
    private function _processMemberGuest($data)
    {
        if (!empty($data)) {
            /** @var array $data */
            foreach ($data as $line) {
                if (!empty($line['Фамилия'])) {
                    $member_info = new MemberInfo();
                    $member_info->setLastName($line['Фамилия']);
                    $member_info->setFirstName($line['Имя']);
                    $member_info->setSecondName($line['Отчество']);
                    $member_info->setMemberFormScenario(MemberForm::SCENARIO_GUESTS);
                    $member_info->setUserId($line['Пользователь']);
                    $member_info->setCreated();
                    $member_info->setUpdated();
                    if (!$member_info->save()) {
                        VarDumper::dump($line, 10, true);
                        VarDumper::dump($member_info->errors, 10, true);
                        return ExitCode::UNSPECIFIED_ERROR;
                    } else {
                        $member_info->saveBadgeNumber(); // Сгененрировать и сохранить номер бейджа
                    }

                    $member = new BaseMemberGuests();
                    $member->setMemberInfoId($member_info->id);
                    if ($line['Статус'] == 'Почетный гость') {
                        $status = BaseMemberGuests::STATUS_VENERABLE_GUEST;
                    } else {
                        $status = BaseMemberGuests::STATUS_GUEST;
                    }
                    $member->setStatus($status);
                    $member->setPlaceWork($line['Место работы']);
                    $member->setPosition($line['Должность']);
                    $member->setCreated();
                    $member->setUpdated();
                    if (!$member->save()) {
                        VarDumper::dump($line, 10, true);
                        VarDumper::dump($member->errors, 10, true);
                        return ExitCode::UNSPECIFIED_ERROR;
                    }
                }
            }
        }
    }

    /**
     * Обработка для файл дирекции и гостей
     * @param $data
     * @return int
     */
    private function _processMemberManagement($data)
    {
        if (!empty($data)) {
            $this->stdout("Данные получены.\n", Console::FG_GREEN);
            /** @var array $data */
            foreach ($data as $line) {
                $this->stdout("Перебор строки....\n", Console::FG_GREEN);
                if (!empty($line['Фамлия'])) {
                    $member_info = new MemberInfo();
                    $member_info->setLastName($line['Фамлия']); // взял название колонки с опечаткой
                    $member_info->setFirstName($line['Имя']);
                    $member_info->setSecondName($line['Отчество']);
                    $member_info->setPhone($line['Номер телефона']);
                    $member_info->setEmail($line['Почта']);
                    $member_info->setMemberFormScenario(MemberForm::SCENARIO_MANAGEMENT);
                    $member_info->setUserId($line['Пользователь']);
                    $member_info->setCreated();
                    $member_info->setUpdated();
                    if (!$member_info->save()) {
                        $this->stdout("Ошибка добавления записи в БД\n", Console::FG_RED);
                        VarDumper::dump($line, 10, true);
                        VarDumper::dump($member_info->errors, 10, true);
                        return ExitCode::UNSPECIFIED_ERROR;
                    } else {
                        $member_info->saveBadgeNumber(); // Сгененрировать и сохранить номер бейджа
                        $this->stdout("Информация об участнике добавлена в БД c id={$member_info->id}. Бейдж сгенерирован\n", Console::FG_GREEN);
                    }

                    $member = new BaseMemberManagement();
                    $member->setMemberInfoId($member_info->id);
                    if ($line['Статус'] == 'организатор') {
                        $status = BaseMemberManagement::STATUS_ORGANIZER;
                    } else {
                        $status = BaseMemberManagement::STATUS_DIRECTORATE;
                    }
                    $member->setStatus($status);
                    $member->setCreated();
                    $member->setUpdated();
                    if (!$member->save()) {
                        $this->stdout("Ошибка добавления записи в БД\n", Console::FG_RED);
                        VarDumper::dump($line, 10, true);
                        VarDumper::dump($member->errors, 10, true);
                        return ExitCode::UNSPECIFIED_ERROR;
                    } else {
                        $this->stdout("Организатор/дирекция добавлена в БД с id={$member->id}\n", Console::FG_GREEN);
                    }
                }
            }
        }
    }

    /**
     * Обработка для файл партнеры
     * @param $data
     * @return int
     */
    private function _processMemberPartners($data)
    {
        if (!empty($data)) {
            $this->stdout("Данные получены.\n", Console::FG_GREEN);
            /** @var array $data */
            foreach ($data as $line) {
                $this->stdout("Перебор строки....\n", Console::FG_GREEN);
                if (!empty($line['Фамилия'])) {
                    $member_info = new MemberInfo();
                    $member_info->setLastName($line['Фамилия']);
                    $member_info->setFirstName($line['Имя']);
                    $member_info->setSecondName($line['Отчество']);
                    $member_info->setEmail($line['Почта']);
                    $member_info->setMemberFormScenario(MemberForm::SCENARIO_PARTNERS);
                    $member_info->setUserId($line['Пользователь']);
                    $member_info->setCreated();
                    $member_info->setUpdated();
                    if (!$member_info->save()) {
                        $this->stdout("Ошибка сохранения информации об участнике в БД\n", Console::FG_RED);
                        VarDumper::dump($line, 10, true);
                        VarDumper::dump($member_info->errors, 10, true);
                        return ExitCode::UNSPECIFIED_ERROR;
                    } else {
                        $this->stdout("Информация об участнике добавлена в БД c id={$member_info->id}. Бейдж сгенерирован\n", Console::FG_GREEN);
                        $member_info->saveBadgeNumber(); // Сгененрировать и сохранить номер бейджа
                    }
                    //Название организации
                    $member = new BaseMemberPartners();
                    $member->setMemberInfoId($member_info->id);
                    $member->setStatus(Role::PARTNERS);
                    $member->setNameOrganization($line['Название организации']);
                    $member->setCreated();
                    $member->setUpdated();
                    if (!$member->save()) {
                        $this->stdout("Ошибка сохранения партнера в БД\n", Console::FG_RED);
                        VarDumper::dump($line, 10, true);
                        VarDumper::dump($member->errors, 10, true);
                        return ExitCode::UNSPECIFIED_ERROR;
                    } else {
                        $this->stdout("Партнер добавлен в БД с id={$member->id}\n", Console::FG_GREEN);
                    }
                }
            }
        }
    }

    /**
     * Обработка для файла технический персонал
     * @param $data
     * @return int
     */
    private function _processMemberTechnicalStaff($data)
    {
        if (!empty($data)) {
            $this->stdout("Данные получены.\n", Console::FG_GREEN);
            /** @var array $data */
            foreach ($data as $line) {
                $this->stdout("Перебор строки....\n", Console::FG_GREEN);
                if (!empty($line['Фамилия'])) {
                    $member_info = new MemberInfo();
                    $member_info->setLastName($line['Фамилия']);
                    $member_info->setFirstName($line['Имя']);
                    $member_info->setSecondName($line['Отчество']);
                    $member_info->setPhone($line['Телефон']);
                    $member_info->setMemberFormScenario(MemberForm::SCENARIO_TECHNICAL_STAFF);
                    $member_info->setUserId($line['Пользователь']);
                    $member_info->setCreated();
                    $member_info->setUpdated();
                    if (!$member_info->save()) {
                        $this->stdout("Ошибка сохранения информации об участнике в БД\n", Console::FG_RED);
                        VarDumper::dump($line, 10, true);
                        VarDumper::dump($member_info->errors, 10, true);
                        return ExitCode::UNSPECIFIED_ERROR;
                    } else {
                        $this->stdout("Информация об участнике добавлена в БД c id={$member_info->id}. Бейдж сгенерирован\n", Console::FG_GREEN);
                        $member_info->saveBadgeNumber(); // Сгененрировать и сохранить номер бейджа
                    }

                    $member = new BaseMemberTechnicalStaff();
                    $member->setMemberInfoId($member_info->id);
                    $member->setStatus(Role::TECHNICAL_STAFF);
                    $member->setCreated();
                    $member->setUpdated();
                    if (!$member->save()) {
                        $this->stdout("Ошибка сохранения технического персонала в БД\n", Console::FG_RED);
                        VarDumper::dump($line, 10, true);
                        VarDumper::dump($member->errors, 10, true);
                        return ExitCode::UNSPECIFIED_ERROR;
                    } else {
                        $this->stdout("Технический персонал добавлен в БД с id={$member->id}\n", Console::FG_GREEN);
                    }
                }
            }
        }
    }

    /**
     * Запарсить все из файла
     *
     * @param $fileName
     * @param $sheet
     * @return string
     */
    private function _parserFile($fileName, $sheet)
    {
        return Excel::widget([
            'mode' => 'import',
            'fileName' => $fileName,
            'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
            'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
            'getOnlySheet' => $sheet, // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
        ]);
    }

    /**
     * Импортирует данные об участниках из import_main_members.xlsx в БД
     * Вкладка должна называться:
     *  Готов ехать
     * Колонки:
     *  Город проведения, Регион проживания, Команда, Капитан/Участник, Роль в команде, Фамилия, Имя, Отчество,
     *  Телефон, Еmail, Размер толстовки
     *
     * @command php yii member/import --member_main
     * @command php yii member/import --member_pupils
     * @command php yii member/import --member_guest
     * @command php yii member/import --member_management
     * @command php yii member/import --member_partners
     * @command php yii member/import --member_technical_staff
     */
    public function actionImport()
    {
        $this->stdout("Начало: ".date('Y-m-d H:i:s')." \n", Console::FG_GREEN);

        $fileName = \Yii::getAlias('@backend').'/web/import_files/';

        if ($this->member_main) {
            $this->stdout("Запуск импорта основных участников \n", Console::FG_GREEN);
            $fileName .= 'import_main_members.xlsx';
            $data = $this->_parserFile($fileName, 'Готов ехать');
            $this->_processMemberMain($data);
        } elseif ($this->member_pupils) {
            $this->stdout("Запуск импорта школьников участников \n", Console::FG_GREEN);
            $fileName .= 'import_pupils_members.xlsx';
            $data = $this->_parserFile($fileName,'Лист1');
            $this->_processMemberPupils($data);
        } elseif ($this->member_guest) {
            $this->stdout("Запуск импорта гостей\n", Console::FG_GREEN);
            $fileName .= 'import_guest_members.xlsx';
            $data = $this->_parserFile($fileName,'Гости');
            $this->_processMemberGuest($data);
        } elseif ($this->member_management) {
            $this->stdout("Запуск импорта организаторов и дирекции\n", Console::FG_GREEN);
            $fileName .= 'import_management_members.xlsx';
            $data = $this->_parserFile($fileName,'Лист1');
            $this->_processMemberManagement($data);
        } elseif ($this->member_partners) {
            $this->stdout("Запуск импорта партнеров\n", Console::FG_GREEN);
            $fileName .= 'import_partners_members.xlsx';
            $data = $this->_parserFile($fileName,'свод бейджей партнеры');
            $this->_processMemberPartners($data);
        } elseif ($this->member_technical_staff) {
            $this->stdout("Запуск импорта технического персонала\n", Console::FG_GREEN);
            $fileName .= 'import_technical_staff_members.xlsx';
            $data = $this->_parserFile($fileName,'Хочу в финал!');
            $this->_processMemberTechnicalStaff($data);
        }

        $this->stdout("Конец: ".date('Y-m-d H:i:s')." \n", Console::FG_GREEN);
        return ExitCode::OK;
    }
}