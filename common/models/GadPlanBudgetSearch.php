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
            [['id', 'user_id', 'lead_responsible_office'], 'integer'],
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
        
        // $query = (new \yii\db\Query())
        // ->select([
        //     '*'
        // ])
        // ->from('gad_plan_budget');

        $query = GadPlanBudget::find()->all();
        

        return $query;
    }
}
