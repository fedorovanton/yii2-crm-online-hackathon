<?php

namespace common\models\MemberGuests;

use Yii;

/**
 * This is the model class for table "member_guests".
 *
 * @property int $id
 * @property int $member_info_id ID инфо участника
 * @property string $status Статус
 * @property string $place_work Место работы
 * @property string $position Должность
 * @property string $created Дата и время добавления
 * @property string $updated Дата и время обновления
 */
class ModelMemberGuests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member_guests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['member_info_id'], 'required'],
            [['member_info_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['status'], 'string', 'max' => 30],
            [['place_work', 'position'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_info_id' => 'ID инфо участника',
            'status' => 'Статус',
            'place_work' => 'Место работы',
            'position' => 'Должность',
            'created' => 'Дата и время добавления',
            'updated' => 'Дата и время обновления',
        ];
    }
}
