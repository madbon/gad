<?php

namespace common\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GadStatusAssignment;

/**
 * GadStatusAssignmentSearch represents the model behind the search form of `common\models\GadStatusAssignment`.
 */
class GadStatusAssignmentSearch extends GadStatusAssignment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['role', 'status','description','rbac_role'], 'safe'],
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
        $query = GadStatusAssignment::find();

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
        ]);

        $query->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'rbac_role', $this->rbac_role])
            ->andFilterWhere(['like', 'description', $this->description])
            ->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
