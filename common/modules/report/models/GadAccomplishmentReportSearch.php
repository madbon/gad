<?php

namespace common\modules\report\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GadAccomplishmentReport;

/**
 * GadAccomplishmentReportSearch represents the model behind the search form of `common\models\GadAccomplishmentReport`.
 */
class GadAccomplishmentReportSearch extends GadAccomplishmentReport
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'record_id', 'focused_id', 'inner_category_id', 'ppa_focused_id'], 'integer'],
            [['ppa_value', 'cause_gender_issue', 'objective', 'relevant_lgu_ppa', 'activity', 'performance_indicator', 'target', 'actual_results', 'variance_remarks', 'date_created', 'time_created', 'date_updated', 'time_updated', 'record_tuc', 'this_tuc'], 'safe'],
            [['total_approved_gad_budget', 'actual_cost_expenditure'], 'number'],
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
        $query = GadAccomplishmentReport::find();

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
            'record_id' => $this->record_id,
            'focused_id' => $this->focused_id,
            'inner_category_id' => $this->inner_category_id,
            'ppa_focused_id' => $this->ppa_focused_id,
            'total_approved_gad_budget' => $this->total_approved_gad_budget,
            'actual_cost_expenditure' => $this->actual_cost_expenditure,
            'date_created' => $this->date_created,
            'date_updated' => $this->date_updated,
        ]);

        $query->andFilterWhere(['like', 'ppa_value', $this->ppa_value])
            ->andFilterWhere(['like', 'cause_gender_issue', $this->cause_gender_issue])
            ->andFilterWhere(['like', 'objective', $this->objective])
            ->andFilterWhere(['like', 'relevant_lgu_ppa', $this->relevant_lgu_ppa])
            ->andFilterWhere(['like', 'activity', $this->activity])
            ->andFilterWhere(['like', 'performance_indicator', $this->performance_indicator])
            ->andFilterWhere(['like', 'target', $this->target])
            ->andFilterWhere(['like', 'actual_results', $this->actual_results])
            ->andFilterWhere(['like', 'variance_remarks', $this->variance_remarks])
            ->andFilterWhere(['like', 'time_created', $this->time_created])
            ->andFilterWhere(['like', 'time_updated', $this->time_updated])
            ->andFilterWhere(['like', 'record_tuc', $this->record_tuc])
            ->andFilterWhere(['like', 'this_tuc', $this->this_tuc]);

        return $dataProvider;
    }
}
