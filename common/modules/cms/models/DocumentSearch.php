<?php

namespace common\modules\cms\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\cms\models\Category;
use yii\db\Query;
use Yii;

/**
 * DocumentSearch represents the model behind the search form of `common\modules\cms\models\Category`.
 */
class DocumentSearch extends Category
{
    /**
     * {@inheritdoc}
     */
    public $ruc;
    public function rules()
    {
        return [
            [['id', 'frequency_id', 'lgup_content_type_id', 'lgup_content_width_id', 'applicable_to', 'left_or_right', 'add_comment'], 'integer'],
            [['title', 'frequency','ruc'], 'safe'],
            [['sort'], 'number'],
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
    public function search_created_document($params)
    {
        $this->load($params);

        $condition = [];
        if(Yii::$app->user->can("gad_field_permission"))
        {
            $condition = ['GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C, 'GR.citymun_c' => Yii::$app->user->identity->userinfo->CITYMUN_C];
        }
        else if(Yii::$app->user->can("gad_region_permission"))
        {
            $condition = ['GR.region_c' => Yii::$app->user->identity->userinfo->REGION_C, 'GR.office_c' => [2,4]];
        }

        $query = (new Query())
        ->select([
            'OFF.office_m as office_name',
            'CAT.title as category_name',
            'CIT.citymun_m as citymun_name',
            'PRO.province_m as province_name',
            'GR.tuc as ruc',
            'GR.year as record_year',
            'GR.report_type_id as report_type',
            'CAT.id as category_id'
        ])
        ->from('gad_cms_values GV')
        ->leftJoin(['GR' => 'gad_record'], 'GR.id = GV.yearly_record_id')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = GR.region_c')
        ->leftJoin(['PRO' => 'tblprovince'], 'PRO.province_c = GR.province_c')
        ->leftJoin(['CIT' => 'tblcitymun'], 'CIT.citymun_c = GR.citymun_c AND CIT.province_c = GR.province_c')
        ->leftJoin(['OFF' => 'tbloffice'], 'OFF.OFFICE_C = GR.office_c')
        ->leftJoin(['CAT' => 'gad_cms_category'], 'CAT.id = GV.category_id')
        ->where($condition)
        ->groupBy(['GV.yearly_record_id','GV.category_id']);
        // ->orderBy(['GR.id' => ]);

        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' =>  10,
                ],
        ]);

        return $dataProvider;
    }

    public function search($params)
    {
        $query = Category::find();

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
            'frequency_id' => $this->frequency_id,
            'lgup_content_type_id' => $this->lgup_content_type_id,
            'lgup_content_width_id' => $this->lgup_content_width_id,
            'applicable_to' => $this->applicable_to,
            'left_or_right' => $this->left_or_right,
            'sort' => $this->sort,
            'add_comment' => $this->add_comment,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'frequency', $this->frequency]);

        return $dataProvider;
    }
}
