<?php

namespace common\models\MemberJury;

use Yii;

/**
 * This is the model class for table "member_jury".
 *
 * @property int $id
 * @property int $member_info_id ID инфо участника
 * @property string $status Статус
 * @property string $place_work Место работы
 * @property string $position Должность
 * @property string $nomination_id Номинация
 * @property string $created Дата и время добавления
 * @property string $updated Дата и время обновления
 */
class ModelMemberJury extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member_jury';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['member_info_id', 'nomination_id'], 'required'],
            [['member_info_id', 'nomination_id'], 'integer'],
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
            'nomination_id' => 'Номинация',
            'place_work' => 'Место работы',
            'position' => 'Должность',
            'created' => 'Дата и время добавления',
            'updated' => 'Дата и время обновления',
        ];
    }
}
