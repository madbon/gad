<?php

namespace common\modules\cms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\cms\models\Category;

/**
 * CategorySearch represents the model behind the search form about `common\modules\cms\models\Category`.
 */
class CategorySearch extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'frequency','sort','applicable_to','left_or_right'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Category::find()->orderBy(['sort' => SORT_ASC]);

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

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'frequency', $this->frequency])
            ->andFilterWhere(['like', 'sort', $this->sort])
            ->andFilterWhere(['like', 'applicable_to', $this->applicable_to])
            ->andFilterWhere(['like', 'left_or_right', $this->left_or_right]);

        return $dataProvider;
    }
}
