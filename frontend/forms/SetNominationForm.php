<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 25/09/2019
 * Time: 20:38
 */

namespace frontend\forms;


use common\models\NominationTeam\BaseNominationTeam;
use frontend\models\MemberMain\MemberMain;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * Формы для определения номинаций у команды капитаном
 *
 * Class SetNominationForm
 * @package frontend\forms
 */
class SetNominationForm extends Model
{
    // Поля для номинаций
    public $member_info_id;
    public $nomination_id_1;
    public $nomination_id_2;
    public $nomination_id_3;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            // Номинации
            [['nomination_id_1', 'nomination_id_2', 'nomination_id_3'], 'required'],
            [['nomination_id_1', 'nomination_id_2', 'nomination_id_3'], 'integer'],

            // ID инфо участника
            ['member_info_id', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'nomination_id_1' => 'Номинация приоритет 1',
            'nomination_id_2' => 'Номинация приоритет 2',
            'nomination_id_3' => 'Номинация приоритет 3',
            'member_info_id' => 'Номинация приоритет 3',
        ];
    }

    /**
     * Создание номинации для команды
     * @param $team_id
     * @param $nomination_id
     * @param $priority
     * @return bool
     */
    private function _createNominationTeam($team_id, $nomination_id, $priority)
    {
            // если номинации еще нет у команды, то сначала удаляем запись с этим приоритетом, если она есть
            $nomination_team = BaseNominationTeam::find()
                ->where(['team_id' => $team_id])
                ->andWhere(['priority' => $priority])
                ->exists();

            if ($nomination_team) return true;

            // затем добавляем эту номинацию для команды с указанным приоритетом
            $nomination_team = new BaseNominationTeam();
            $nomination_team->setTeamId($team_id);
            $nomination_team->setNominationId($nomination_id);
            $nomination_team->setPriority($priority);
            $nomination_team->setUpdated();
            $nomination_team->setCreated();
            $nomination_team->save();
    }

    /**
     * Сохранение формы
     */
    public function saveForm()
    {
        /** @var MemberMain $member */
        $member = MemberMain::find()->where(['member_info_id' => $this->member_info_id])->one();

        if (!empty($member->team->nominationsTeam)) {
            return false;
        }

        if ($member) {
            $this->_createNominationTeam($member->team_id, $this->nomination_id_1, BaseNominationTeam::PRIORITY_1);
            $this->_createNominationTeam($member->team_id, $this->nomination_id_2, BaseNominationTeam::PRIORITY_2);
            $this->_createNominationTeam($member->team_id, $this->nomination_id_3, BaseNominationTeam::PRIORITY_3);
            return true;
        }

        return false;
    }
}