<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 26/09/2019
 * Time: 22:07
 */

namespace console\controllers;


use common\components\Role;
use frontend\models\MemberInfo\MemberInfo;
use yii\console\Controller;
use Yii;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Контроллер для работы с файлами
 * Class FileController
 * @package console\controllers
 */
class FileController extends Controller
{
    /**
     * Создать директорию с каталогом для пользователя
     * @param $user_dir_name
     * @return string
     */
    private function _createUserDir($role, $user_dir_name)
    {
        $dir = Yii::getAlias('@backend').'/web/docs/'.$role.'/'.$user_dir_name;
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        return $dir;
    }

    private function _createRoleDir($role)
    {
        $dir = Yii::getAlias('@backend').'/web/docs/'.$role;
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        return $dir;
    }

    private function _copyMember($role)
    {
        $members__batch = MemberInfo::find()->where(['member_form_scenario' => $role])->batch();

        switch ($role) {
            case Role::MEMBERS_MAIN:
                $relation = 'memberMain';
                break;
            case Role::MEMBERS_UNIVERSITIES:
                $relation = 'memberUniversities';
                break;
            case Role::MEMBERS_PUPILS:
                $relation = 'memberPupils';
                break;
        }

        $this->_createRoleDir($role);

        foreach ($members__batch as $members) {
            foreach ($members as $member) {
                /** @var MemberInfo $member */

                $this->stdout("Обработка участника id={$member->getFullName()}\n", Console::FG_BLUE);

                if (!empty($member->$relation->doc_file)) {
                    $from_copy = Yii::getAlias('@backend').'/web/uploads/members-doc-file/'.$member->$relation->doc_file;
                    $this->stdout("Копировать ИЗ: {$from_copy}\n", Console::FG_BLUE);

                    $to_copy = $this->_createUserDir($role, $member->user_id.'_'.$member->user->fio).'/'.$member->id.'_'.$member->getFullName().'.pdf';
                    $this->stdout("Копировать В: {$to_copy}\n", Console::FG_BLUE);

                    if (!copy($from_copy, $to_copy)) {
                        $this->stdout("Не удалось скопировать файл для участника id={$member->id}\n", Console::FG_RED);
                    } else {
                        $this->stdout("Скопирован файл для участника id={$member->id}\n", Console::FG_GREEN);
                        $this->stdout("в директорию: {$to_copy}\n", Console::FG_GREEN);
                    }
                } else {
                    $this->stdout("У участника id={$member->id} отсутствует документ.\n", Console::FG_RED);
                }
            }
        }
    }

    /**
     * Копирование файлов в необходимые директории
     * @command php yii file/copy
     */
    public function actionCopy()
    {
        $this->stdout("Начало: ".date('Y-m-d H:i:s')." \n", Console::FG_GREEN);

        $this->_copyMember(Role::MEMBERS_MAIN);
        $this->_copyMember(Role::MEMBERS_UNIVERSITIES);
        $this->_copyMember(Role::MEMBERS_PUPILS);

        $this->stdout("Конец: ".date('Y-m-d H:i:s')." \n", Console::FG_GREEN);
        return ExitCode::OK;

    }

}