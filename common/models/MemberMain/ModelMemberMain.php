<?php

namespace common\models\MemberMain;

use Yii;

/**
 * This is the model class for table "member_main".
 *
 * @property int $id
 * @property int $member_info_id ID инфо участника
 * @property int $team_id ID основной команды участников
 * @property int $member_position Позиция участника в команде, ID основной команды участников
 * @property string $clothing_size Размер одежды
 * @property string $region_residence Регион проживания
 * @property int $team_status Статус в команде
 * @property int $is_plans_live_in_city Планируете ли проживать в г.Казань
 * @property string $address_live_in_city Адрес проживания в г.Казань
 * @property string $qr_code QR-code
 * @property string $doc_file Документ
 * @property string $created Дата и время добавления
 * @property string $updated Дата и время обновления
 */
class ModelMemberMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['member_info_id'], 'required'],
            [['member_info_id', 'team_id', 'team_status'], 'integer'],
            [['created', 'updated'], 'safe'],
            ['is_plans_live_in_city', 'string', 'max' => 3],
            ['qr_code', 'string', 'max' => 1024],
            ['clothing_size', 'string', 'max' => 5],
            [['address_live_in_city', 'region_residence'], 'string', 'max' => 255],
            ['member_position', 'integer'],
            [['doc_file'], 'string', 'max' => 1024],
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
            'team_id' => 'ID основной команды участников',
            'member_position' => 'Позиция участника в команде',
            'clothing_size' => 'Размер одежды',
            'region_residence' => 'Регион проживания',
            'team_status' => 'Статус в команде',
            'is_plans_live_in_city' => 'Планируете ли проживать в г.Казань',
            'address_live_in_city' => 'Адрес проживания в г.Казань',
            'qr_code' => 'QR-code',
            'doc_file' => 'Резюме',
            'created' => 'Дата и время добавления',
            'updated' => 'Дата и время обновления',
        ];
    }
}
