<?php

namespace common\modules\rms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\rms\models\UploadedClient;

/**
 * UploadedClientSearch represents the model behind the search form of `common\modules\rms\models\UploadedClient`.
 */
class UploadedClientSearch extends UploadedClient
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'business_type'], 'integer'],
            [['region_c', 'province_c', 'citymun_c', 'first_name', 'middle_name', 'last_name', 'application_no', 'business_name', 'business_tin', 'application_date', 'date_uploaded'], 'safe'],
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

        $region_c = Yii::$app->user->identity->userinfo->REGION_C;
        $province_c = Yii::$app->user->identity->userinfo->PROVINCE_C;
        $citymun_c = Yii::$app->user->identity->userinfo->CITYMUN_C;
        
        $query = UploadedClient::find()->where(['region_c' => $region_c,'province_c' => $province_c,'citymun_c' => $citymun_c])->orderBy(['application_no' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
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
            'application_date' => $this->application_date,
            'date_uploaded' => $this->date_uploaded,
            'business_type' => $this->business_type,
        ]);

        $query->andFilterWhere(['like', 'region_c', $this->region_c])
            ->andFilterWhere(['like', 'province_c', $this->province_c])
            ->andFilterWhere(['like', 'citymun_c', $this->citymun_c])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'application_no', $this->application_no])
            ->andFilterWhere(['like', 'business_name', $this->business_name])
            ->andFilterWhere(['like', 'business_tin', $this->business_tin]);

        return $dataProvider;
    }
}
