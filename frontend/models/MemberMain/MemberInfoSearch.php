<?php

namespace frontend\models\MemberMain;

use common\components\Role;
use common\models\MemberInfo\BaseMemberInfo;
use frontend\models\MemberInfo\MemberInfo;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MemberInfo\ModelMemberInfo;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\User;

/**
 * MemberInfoSearch represents the model behind the search form of `common\models\MemberInfo\ModelMemberInfo`.
 */
class MemberInfoSearch extends MemberInfo
{
    public $fio;
    public $member_form_scenario;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'isValidSmsCode', 'badge_issued', 'user_id'], 'integer'],
            [['first_name', 'last_name', 'second_name', 'phone', 'email', 'badge_number', 'sms_code', 'sms_result', 'token', 'created', 'updated'], 'safe'],
            [['fio', 'member_form_scenario'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $user = Yii::$app->user->identity;

        $this->load($params);
        $this->validate();

        // Дефолтные значения
        if (($user->role != Role::MEMBERS_MAIN) && ($user->role != Role::ACCREDITATION)) {
            // Показывать список участников авторизованного пользователя для всех списков, кроме основых участников
            $this->user_id = $user->getId();
        }

        // Показывать списки участников в зависимости от роли пользователя
        if ($user->role != Role::ACCREDITATION) {
            $this->member_form_scenario = $user->role;
        }

        $query = MemberInfo::find();

        $query->andFilterWhere([
            'id' => $this->id,
            'isValidSmsCode' => $this->isValidSmsCode,
            'user_id' => $this->user_id,
            'created' => $this->created,
            'updated' => $this->updated,
            'badge_issued' => $this->badge_issued,
        ]);

        if ($user->role == Role::ACCREDITATION) {
            // Аккредитация может смотреть только участников вузы, основные, школьники
            if (empty($this->member_form_scenario)) {
                // По умолчанию показываем эти 3 списка
                $query->andFilterWhere(['IN', 'member_form_scenario', [Role::MEMBERS_PUPILS, Role::MEMBERS_UNIVERSITIES, Role::MEMBERS_MAIN]]);
            } else {
                $query->andFilterWhere(['member_form_scenario' => $this->member_form_scenario]);
            }
        } else {
            $query->andFilterWhere(['member_form_scenario' => $this->member_form_scenario]);
        }

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'second_name', $this->second_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'badge_number', $this->badge_number])
            ->andFilterWhere(['like', 'sms_code', $this->sms_code])
            ->andFilterWhere(['like', 'sms_result', $this->sms_result])
            ->andFilterWhere(['like', 'token', $this->token]);

        $query->andFilterWhere(['like', 'last_name', $this->fio]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'pagination' => ['pageSize' => 25,],
            'sort' => [
                'attributes' => [
                    'badge_number',
                    'fio' => [
                        'asc' => ['last_name' => SORT_ASC],
                        'desc' => ['last_name' => SORT_DESC],
                    ],
                    'check_status',
                    'badge_issued',
                ],
                'defaultOrder' => ['fio' => SORT_ASC]
        ]
        ]);

        return $dataProvider;
    }
}
