<?php

namespace common\models\Team;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property string $name Название
 * @property string $city_regional_stage Город проведения регионального этапа
 * @property integer $user_id ID пользователя представителя
 * @property string $user_create_role Сценарий формы создания участника
 * @property string $created Дата и время добавления
 * @property string $updated Дата и время обновления
 */
class ModelTeam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created', 'updated'], 'safe'],
            [['name', 'city_regional_stage'], 'string', 'max' => 255],
            ['user_id', 'integer'],
            ['user_create_role', 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                    => 'ID',
            'name'                  => 'Название команды',
            'city_regional_stage'   => 'Город проведения регионального этапа',
            'user_id'               => 'ID пользователя представителя',
            'user_create_role'      => 'Роль пользователя создавший команду',
            'created'               => 'Дата и время добавления',
            'updated'               => 'Дата и время обновления',
        ];
    }
}
