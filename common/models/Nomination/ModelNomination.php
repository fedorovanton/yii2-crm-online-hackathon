<?php

namespace common\models\Nomination;

use Yii;

/**
 * This is the model class for table "nomination".
 *
 * @property int $id
 * @property string $name Название
 * @property string $role Роль
 * @property string $created Дата и время добавления
 * @property string $updated Дата и время обновления
 */
class ModelNomination extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nomination';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created', 'updated'], 'safe'],
            [['name', 'role'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'role' => 'Роль',
            'created' => 'Дата и время добавления',
            'updated' => 'Дата и время обновления',
        ];
    }
}
