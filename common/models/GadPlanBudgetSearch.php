<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GadPlanBudget;
use Yii;
/**
 * GadPlanBudgetSearch represents the model behind the search form of `common\models\GadPlanBudget`.
 */
class GadPlanBudgetSearch extends GadPlanBudget
{
    /**
     * {@inheritdoc}
     */
    public $ruc;
    public function rules()
    {
        return [
            [['id', 'user_id', 'lead_responsible_office'], 'integer'],
            [['region_c', 'province_c', 'citymun_c', 'issue_mandate', 'objective', 'relevant_lgu_program_project', 'activity', 'performance_indicator_target', 'date_created', 'time_created', 'date_updated', 'time_updated', 'tuc_parent','focused_id','ruc'], 'safe'],
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
        $this->load($params);

        $dataPlanBudget = (new \yii\db\Query())
        ->select([
            'PB.id',
            'PB.ppa_value',
            // 'IF(PB.ppa_focused_id = 0, PB.cause_gender_issue,CF.title) as activity_category',
            'PB.cause_gender_issue as other_activity_category',
            'PB.objective',
            'PB.relevant_lgu_program_project',
            'PB.activity',
            'PB.performance_target',
            'PB.performance_indicator',
            'PB.budget_mooe',
            'PB.budget_ps',
            'PB.budget_co',
            'PB.lead_responsible_office',
            'COUNT(GC.plan_budget_id) as count_comment',
            'GC.attribute_name as attr_name',
            'PB.record_tuc as record_uc',
            'GF.title as gad_focused_title',
            'IC.title as inner_category_title',
            'GC.id as gad_focused_id',
            'IC.id as inner_category_id',
            'PB.focused_id',
            'PB.gi_sup_data as sup_data',
            'REC.status as record_status',
            'PB.source as source_value',
            'PB.old_plan_id'
        ])
        ->from('gad_plan_budget PB')
        // ->leftJoin(['CF' => 'gad_ppa_client_focused'], 'CF.id = PB.ppa_focused_id')
        ->leftJoin(['GC' => 'gad_comment'], 'GC.plan_budget_id = PB.id')
        ->leftJoin(['GF' => 'gad_focused'], 'GF.id = PB.focused_id')
        ->leftJoin(['IC' => 'gad_inner_category'], 'IC.id = PB.inner_category_id')
        ->leftJoin(['REC' => 'gad_record'], 'REC.id = PB.record_id')
        ->where(['PB.record_tuc' => Yii::$app->session["record_tuc"]])
        ->andFilterWhere(['PB.focused_id' => $this->focused_id])
        ->orderBy(['PB.focused_id' => SORT_ASC,'PB.inner_category_id' => SORT_ASC,'PB.ppa_value' => SORT_ASC,'PB.id' => SORT_ASC])
        ->groupBy(['PB.focused_id','PB.inner_category_id','PB.ppa_value','PB.objective','PB.relevant_lgu_program_project','PB.activity','PB.performance_target','PB.id'])
        ->all();
        // print_r($dataPlanBudget->createCommand()->rawSql); exit;
        Yii::$app->session['session_dataPlanBudget'] = $dataPlanBudget;

        return $dataPlanBudget;
    }
}
