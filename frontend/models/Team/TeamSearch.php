<?php

namespace frontend\models\Team;

use common\components\Role;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;
use yii\helpers\VarDumper;

/**
 * TeamSearch represents the model behind the search form of `frontend\models\Team\Team`.
 */
class TeamSearch extends Team
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'city_regional_stage', 'created', 'updated', 'user_create_role'], 'safe'],
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

        // Дефолтные
        if (($user->role != Role::MEMBERS_MAIN) && ($user->role != Role::ACCREDITATION)) {
            // Показывать список команд только того пользователя, который создал команду
            $this->user_id = $user->getId();
        }

        // Показывать списки команд в зависимости от роли пользователя
        if ($user->role != Role::ACCREDITATION) {
            $this->user_create_role = $user->role;
        }

        $query = Team::find();

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_create_role' => $this->user_create_role,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'city_regional_stage', $this->city_regional_stage]);

        return new ActiveDataProvider([
            'query' => $query,
//            'pagination' => ['pageSize' => 25],
//            'sort'=> ['defaultOrder' => ['updated' => SORT_DESC]]
        ]);
    }
}
