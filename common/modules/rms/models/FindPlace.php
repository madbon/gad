<?php

namespace common\modules\rms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\rms\models\Citymun;
use yii\db\Query;

/**
 * CitymunSearch represents the model behind the search form of `common\modules\dynamicview\models\Citymun`.
 */
class FindPlace extends Citymun
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_c', 'province_c', 'district_c', 'citymun_c', 'citymun_m', 'lgu_type','place','region_name','choose_prov_city'], 'safe'],
            [['province_c','hris_i_country_id'], 'required', 'when' => function ($model) { return $model->region_c != null; }, 'whenClient' => "function (attribute, value) { return $('#findplace-region_c').val() != null; }"]
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_c' => 'Region',
            'province_c' => 'Province',
            'district_c' => 'District C',
            'citymun_c' => 'Citymun C',
            'citymun_m' => 'Citymun M',
            'lgu_type' => 'Lgu Type',
            'region_name' => 'Reg',

        ];
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
        // $query = Citymun::find();
        $this->load($params);

        $exploded = explode(",",$this->place);

        
        $city_c = !empty($this->place) ? $exploded[0] : $this->citymun_c;
        $prov_c = !empty($this->place) ? $exploded[1] : $this->province_c;
        $reg_c = !empty($this->place) ? $exploded[2] : $this->region_c;
        // print_r($reg_c); exit;
        
        // print_r($city_c.",".$prov_c.",".$reg_c); exit;


        $query = (new Query())
                ->select([
                            "CONCAT(CC.citymun_c,PC.province_c,RC.region_c) as id,CONCAT(CC.citymun_m, ', ', PC.province_m, ', ',RC.region_m) as text",
                            "RC.region_m as region_name",
                            "PC.province_m as province_name",
                            "CC.citymun_m as citymun_name",
                            "RC.region_c as region_id",
                            "PC.province_c as province_id",
                            "CC.citymun_c as citymun_id"
                         ])
                ->from('tblcitymun CC')
                ->leftJoin(['RC' => 'tblregion'], 'RC.region_c = CC.region_c')
                ->leftJoin(['PC' => 'tblprovince'], 'PC.province_c = CC.province_c')
                ->andFilterWhere(['like','RC.region_c',!empty($reg_c) ? $reg_c : "abc"])
                ->andFilterWhere(['like','PC.province_c', $prov_c])
                ->andFilterWhere(['like','CC.citymun_c', $city_c]);

                // print_r($query); exit;
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
        // $query->andFilterWhere(['like', 'region_c', $this->region_c])
        //     ->andFilterWhere(['like', 'province_c', $this->province_c])
        //     ->andFilterWhere(['like', 'district_c', $this->district_c])
        //     ->andFilterWhere(['like', 'citymun_c', $this->place])
        //     ->andFilterWhere(['like', 'citymun_m', $this->citymun_m])
        //     ->andFilterWhere(['like', 'lgu_type', $this->lgu_type])
        //     ->andFilterWhere(['like', 'lgu_type', $this->lgu_type]);

        return $dataProvider;
    }
}
