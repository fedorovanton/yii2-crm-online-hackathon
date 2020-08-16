<?php

namespace common\models\NominationTeam;

use Yii;

/**
 * This is the model class for table "nomination_team".
 *
 * @property int $id
 * @property int $nomination_id ID номинации
 * @property int $team_id ID команды
 * @property int $priority Приоритет
 * @property string $created Дата и время добавления
 * @property string $updated Дата и время обновления
 */
class ModelNominationTeam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nomination_team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomination_id', 'team_id'], 'required'],
            [['nomination_id', 'team_id'], 'integer'],
            ['priority', 'string', 'max' => 10],
            [['created', 'updated'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomination_id' => 'ID номинации',
            'team_id' => 'ID команды',
            'priority' => 'Приоритет',
            'created' => 'Дата и время добавления',
            'updated' => 'Дата и время обновления',
        ];
    }
}
