<?php

namespace common\modules\cms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\cms\models\CmsContentWidth;

/**
 * CmsContentWidthSearch represents the model behind the search form of `common\modules\cms\models\CmsContentWidth`.
 */
class CmsContentWidthSearch extends CmsContentWidth
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['class_name', 'description'], 'safe'],
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
        $query = CmsContentWidth::find();

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

        $query->andFilterWhere(['like', 'class_name', $this->class_name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
