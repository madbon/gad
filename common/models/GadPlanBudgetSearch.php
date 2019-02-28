<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GadPlanBudget;

/**
 * GadPlanBudgetSearch represents the model behind the search form of `common\models\GadPlanBudget`.
 */
class GadPlanBudgetSearch extends GadPlanBudget
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'lead_responsible_office_id'], 'integer'],
            [['region_c', 'province_c', 'citymun_c', 'issue_mandate', 'objective', 'relevant_lgu_program_project', 'activity', 'performance_indicator_target', 'date_created', 'time_created', 'date_updated', 'time_updated', 'tuc_parent'], 'safe'],
            [['budget_mooe', 'budget_ps', 'budget_co', 'sort'], 'number'],
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
        $query = GadPlanBudget::find();

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
            'user_id' => $this->user_id,
            'budget_mooe' => $this->budget_mooe,
            'budget_ps' => $this->budget_ps,
            'budget_co' => $this->budget_co,
            'lead_responsible_office_id' => $this->lead_responsible_office_id,
            'date_created' => $this->date_created,
            'date_updated' => $this->date_updated,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'region_c', $this->region_c])
            ->andFilterWhere(['like', 'province_c', $this->province_c])
            ->andFilterWhere(['like', 'citymun_c', $this->citymun_c])
            ->andFilterWhere(['like', 'issue_mandate', $this->issue_mandate])
            ->andFilterWhere(['like', 'objective', $this->objective])
            ->andFilterWhere(['like', 'relevant_lgu_program_project', $this->relevant_lgu_program_project])
            ->andFilterWhere(['like', 'activity', $this->activity])
            ->andFilterWhere(['like', 'performance_indicator_target', $this->performance_indicator_target])
            ->andFilterWhere(['like', 'time_created', $this->time_created])
            ->andFilterWhere(['like', 'time_updated', $this->time_updated])
            ->andFilterWhere(['like', 'tuc_parent', $this->tuc_parent]);

        return $dataProvider;
    }
}
