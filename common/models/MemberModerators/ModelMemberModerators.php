<?php

namespace common\models\MemberModerators;

use Yii;

/**
 * This is the model class for table "member_moderators".
 *
 * @property int $id
 * @property int $member_info_id ID инфо участника
 * @property string $status Статус
 * @property string $created Дата и время добавления
 * @property string $updated Дата и время обновления
 */
class ModelMemberModerators extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member_moderators';
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
            [['status'], 'string', 'max' => 255],
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
            'created' => 'Дата и время добавления',
            'updated' => 'Дата и время обновления',
        ];
    }
}
