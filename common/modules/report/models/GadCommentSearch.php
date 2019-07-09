<?php

namespace common\modules\report\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GadComment;

/**
 * GadCommentSearch represents the model behind the search form of `common\models\GadComment`.
 */
class GadCommentSearch extends GadComment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'resp_user_id', 'resp_office_c', 'record_id', 'plan_budget_id', 'row_no', 'column_no'], 'integer'],
            [['resp_region_c', 'resp_province_c', 'resp_citymun_c', 'comment', 'row_value', 'column_value', 'model_name', 'attribute_name', 'date_created', 'time_created', 'date_updated', 'time_updated'], 'safe'],
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
        $query = GadComment::find();

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
            'resp_user_id' => $this->resp_user_id,
            'resp_office_c' => $this->resp_office_c,
            'record_id' => $this->record_id,
            'plan_budget_id' => $this->plan_budget_id,
            'row_no' => $this->row_no,
            'column_no' => $this->column_no,
            'date_created' => $this->date_created,
            'date_updated' => $this->date_updated,
        ]);

        $query->andFilterWhere(['like', 'resp_region_c', $this->resp_region_c])
            ->andFilterWhere(['like', 'resp_province_c', $this->resp_province_c])
            ->andFilterWhere(['like', 'resp_citymun_c', $this->resp_citymun_c])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'row_value', $this->row_value])
            ->andFilterWhere(['like', 'column_value', $this->column_value])
            ->andFilterWhere(['like', 'model_name', $this->model_name])
            ->andFilterWhere(['like', 'attribute_name', $this->attribute_name])
            ->andFilterWhere(['like', 'time_created', $this->time_created])
            ->andFilterWhere(['like', 'time_updated', $this->time_updated]);

        return $dataProvider;
    }
}
