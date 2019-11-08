<?php

namespace common\modules\report\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GadReportHistory;

/**
 * GadReportHistorySearch represents the model behind the search form of `common\models\GadReportHistory`.
 */
class GadReportHistorySearch extends GadReportHistory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'responsible_office_c', 'responsible_user_id'], 'integer'],
            [['remarks', 'tuc', 'responsible_region_c', 'responsible_province_c', 'responsible_citymun_c', 'fullname', 'date_created', 'time_created'], 'safe'],
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
        $query = GadReportHistory::find();

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
            'status' => $this->status,
            'responsible_office_c' => $this->responsible_office_c,
            'responsible_user_id' => $this->responsible_user_id,
            'date_created' => $this->date_created,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'tuc', $this->tuc])
            ->andFilterWhere(['like', 'responsible_region_c', $this->responsible_region_c])
            ->andFilterWhere(['like', 'responsible_province_c', $this->responsible_province_c])
            ->andFilterWhere(['like', 'responsible_citymun_c', $this->responsible_citymun_c])
            ->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'time_created', $this->time_created])
            ->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
