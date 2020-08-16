<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 19:37
 */

namespace common\models\MemberMain;


use common\models\NominationTeam\BaseNominationTeam;
use frontend\models\Team\Team;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Обертка над классом MemberMain
 *
 * Class BaseMemberMain
 * @property Team team read-only
 * @package common\models\MemberMain
 */
class BaseMemberMain extends ModelMemberMain
{
    /**
     * Участник планирует проживать в городе Казань
     */
    const IS_LIVE_IN_KASAN = 'Да';

    /**
     * Участник не планирует проживать в городе Казань
     */
    const IS_NO_LIVE_IN_KASAN = 'Нет';

    /**
     * Статус в команде - Капитан
     */
    const TEAM_STATUS_CAPTAIN = 1;

    /**
     * Статус в команде - Участник
     */
    const TEAM_STATUS_MEMBER = 2;

    /**
     * Геттер массив с размерами одежды
     * @return array
     */
    public static function getClothingSizeArray()
    {
        return [
            'XS' => 'XS',
            'S' => 'S',
            'М' => 'М',
            'L' => 'L',
            'XL' => 'XL',
            'XXL' => 'XXL',
        ];
    }

    /**
     * Геттер массив с размерами одежды
     * @return array
     */
    public static function getTeamStatusArray()
    {
        return [
            self::TEAM_STATUS_CAPTAIN => 'Капитан',
            self::TEAM_STATUS_MEMBER => 'Участник',
        ];
    }

    /**
     * Получить статус участника в команде
     *
     * @return mixed
     */
    public function getTeamStatusName()
    {
        return ArrayHelper::getValue(self::getTeamStatusArray(), $this->team_status);
    }


    /**
     * Геттер массив с Да/Нет проживание в городе Казань
     * @return array
     */
    public static function getPlansLiveInCityArray()
    {
        return [
            self::IS_LIVE_IN_KASAN => 'Да',
            self::IS_NO_LIVE_IN_KASAN => 'Нет',
        ];
    }

    /**
     * Сеттер размер одежды
     *
     * @param $size
     */
    public function setClothingSize($size)
    {
        $this->clothing_size = $size;
    }

    /**
     * Сеттер стаутс в команде
     *
     * @param $status
     */
    public function setTeamStatus($status)
    {
        $this->team_status = $status;
    }

    /**
     * Сеттер ID команды
     *
     * @param $teamID
     */
    public function setTeamId($teamID)
    {
        $this->team_id = $teamID;
    }

    /**
     * Сеттер Регион проживания
     *
     * @param $region
     */
    public function setRegionResidence($region)
    {
        $this->region_residence = $region;
    }

    /**
     * Сеттер ID инфо об участнике
     *
     * @param $memberInfoId
     */
    public function setMemberInfoId($memberInfoId)
    {
        $this->member_info_id = $memberInfoId;
    }

    /**
     * Сеттер Планируете ли проживать в г.Казань
     *
     * @param $string
     */
    public function setIsPlansLiveInCity($string)
    {
        $this->is_plans_live_in_city = $string;
    }

    /**
     * Сеттер Адрес проживания в г.Казань
     * @param $address
     */
    public function setAddressLiveInCity($address)
    {
        $this->address_live_in_city = $address;
    }

    /**
     * Сеттер дата и время добавения записи
     */
    public function setCreated()
    {
        $this->created = date('Y-m-d H:i:s');
    }

    /**
     * Сеттер дата и время  обновления записи
     */
    public function setUpdated()
    {
        $this->updated = date('Y-m-d H:i:s');
    }

    /**
     * Сеттер позиция участника в команде
     * @param $position
     */
    public function setMemberPosition($position)
    {
        $this->member_position = $position;
    }

    /**
     * Загрузка документа из формы, у которой поле для этого называется docFile
     *
     * @param $form
     * @return string
     */
    public function upload($form)
    {
        $file = $form->docFile;

        $file_upload_path = \Yii::getAlias('@backend').'/web/uploads/members-doc-file/';
        $file_name = Yii::$app->security->generateRandomString(). '.' . $file->extension;
        $file->saveAs($file_upload_path.$file_name);
        return $file_name;
    }

    /**
     * Связь с командами
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }

    /**
     * Получить итоговую номинацию команды, в которой участник
     * @return string
     */
    public function getFinalNomination()
    {
        // есть ли команда у участника
        if (empty($this->team)) {
            return 'Команда отсутствует';
        } else {
            // Есть ли номинация у команды
            if ($this->team->nominationsTeam) {
                foreach ($this->team->nominationsTeam as $nomination_team) {
                    /** @var BaseNominationTeam $nomination_team */
                    // ищем в цикле Итоговую номинацию
                    if ($nomination_team->priority == BaseNominationTeam::PRIORITY_FINAL) {
                        return $nomination_team->nomination->name;
                    }
                }
            } else {
                return 'Не определена';
            }
        }

        return 'Не определена';
    }
}