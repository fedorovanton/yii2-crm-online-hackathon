<?php

namespace backend\models\MemberInfo;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MemberInfo\BaseMemberInfo;

/**
 * MemberInfoSearch represents the model behind the search form of `common\models\MemberInfo\BaseMemberInfo`.
 */
class MemberInfoSearch extends BaseMemberInfo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'isValidSmsCode', 'user_id'], 'integer'],
            [['first_name', 'last_name', 'second_name', 'phone', 'email', 'badge_number', 'sms_code', 'sms_result', 'token', 'member_form_scenario', 'created', 'updated'], 'safe'],
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
        $query = BaseMemberInfo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'isValidSmsCode' => $this->isValidSmsCode,
            'user_id' => $this->user_id,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'second_name', $this->second_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'badge_number', $this->badge_number])
            ->andFilterWhere(['like', 'sms_code', $this->sms_code])
            ->andFilterWhere(['like', 'sms_result', $this->sms_result])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'member_form_scenario', $this->member_form_scenario]);

        return $dataProvider;
    }
}
