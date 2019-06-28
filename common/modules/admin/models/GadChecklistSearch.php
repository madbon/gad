<?php

namespace common\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GadChecklist;

/**
 * GadChecklistSearch represents the model behind the search form of `common\models\GadChecklist`.
 */
class GadChecklistSearch extends GadChecklist
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'report_type_id', 'is_hidden'], 'integer'],
            [['title'], 'safe'],
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
        $query = GadChecklist::find();

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
            'report_type_id' => $this->report_type_id,
            'is_hidden' => $this->is_hidden,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
