<?php

namespace common\models\Region;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $id
 * @property string $name Название
 * @property string $created Дата и время добавления
 * @property string $updated Дата и время обновления
 */
class ModelRegion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created', 'updated'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'created' => 'Дата и время добавления',
            'updated' => 'Дата и время обновления',
        ];
    }
}
