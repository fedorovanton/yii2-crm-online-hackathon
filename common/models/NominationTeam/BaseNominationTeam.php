<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 19/09/2019
 * Time: 16:06
 */

namespace common\models\NominationTeam;


use common\models\Nomination\BaseNomination;


/**
 * Class BaseNominationTeam
 * @property BaseNomination nomination Номинация
 * @package common\models\NominationTeam
 */
class BaseNominationTeam extends ModelNominationTeam
{
    /**
     * Приоритет - в первую очередь
     */
    const PRIORITY_1 = '1';

    /**
     * Приоритет - во вторую очередь
     */
    const PRIORITY_2 = '2';

    /**
     * Приоритет - в третью очередь
     */
    const PRIORITY_3 = '3';

    /**
     * Приоритет - итоговая номинация
     */
    const PRIORITY_FINAL = 'final';

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
     * Сеттер ID команды
     * @param $id
     */
    public function setTeamId($id)
    {
        $this->team_id = $id;
    }

    /**
     * Сеттер ID номинации
     * @param $id
     */
    public function setNominationId($id)
    {
        $this->nomination_id = $id;
    }

    /**
     * Сеттер приоритета
     * @param $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * Связь с номинациями
     * @return \yii\db\ActiveQuery
     */
    public function getNomination()
    {
        return $this->hasOne(BaseNomination::className(), ['id' => 'nomination_id']);
    }
}