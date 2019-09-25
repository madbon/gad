<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_plan_budget".
 *
 * @property int $id
 * @property int $user_id
 * @property string $region_c
 * @property string $province_c
 * @property string $citymun_c
 * @property string $cause_gender_issue
 * @property string $objective
 * @property string $relevant_lgu_program_project
 * @property string $activity
 * @property string $performance_target
 * @property string $budget_mooe
 * @property string $budget_ps
 * @property string $budget_co
 * @property int $lead_responsible_office
 * @property string $date_created
 * @property string $time_created
 * @property string $date_updated
 * @property string $time_updated
 * @property string $sort
 * @property string $tuc_parent
 */
class GadPlanBudget extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            'fileBehavior' => [
                'class' => \file\behaviors\FileBehavior::className()
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_plan_budget';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['focused_id','inner_category_id','user_id','ppa_focused_id'], 'integer'],
            // [['cause_gender_issue', 'objective', 'relevant_lgu_program_project', 'activity', 'performance_target','performance_indicator'], 'string'],
            [['budget_mooe', 'budget_ps', 'budget_co', 'sort'], 'number'],
            // [['cause_gender_issue','ppa_value','objective','relevant_lgu_program_project','activity','performance_target'], 'required'],
            [['ppa_value','relevant_lgu_program_project','objective','activity','performance_target','lead_responsible_office','activity_category_id'],'required'],
            [['ppa_value'], Yii::$app->controller->action->id == "update-ppa-value" ? "required" : "safe"],
            [['relevant_lgu_program_project'], Yii::$app->controller->action->id == "update-relevant-lgu-program-project"  ? "required" : "safe"],
            [['objective'], Yii::$app->controller->action->id == "update-objective" ? "required" : "safe"],
            [['activity'], Yii::$app->controller->action->id == "update-activity" ? "required" : "safe"],
            [['performance_target'], Yii::$app->controller->action->id == "update-performance-target" ? "required" : "safe"],
            [['performance_indicator'], Yii::$app->controller->action->id == "update-performance-indicator" ? "required" : "safe"],
            [['lead_responsible_office'], Yii::$app->controller->action->id == "update-lead-responsible-office" ? "required" : "safe"],
            
            [['budget_mooe'], Yii::$app->controller->action->id == "update-budget-mooe" ? "required" : "safe"],
            [['budget_ps'], Yii::$app->controller->action->id == "update-budget-ps" ? "required" : "safe"],
            [['budget_co'], Yii::$app->controller->action->id == "update-budget-co" ? "required" : "safe"],

            [['inner_category_id','focused_id','cliorg_ppa_attributed_program_id','date_implement_start'], Yii::$app->controller->id == "plan" || Yii::$app->controller->action->id == "create-gad-plan-budget" ? 'required' : 'safe'],
            [['date_implement_end'], Yii::$app->controller->id == "plan" ? 'required' : 'safe'],
            [['date_created', 'date_updated','date_implementation','old_plan_id'], 'safe'],
            [['time_created', 'time_updated'], 'string', 'max' => 10],
            [['record_tuc','tuc'], 'string', 'max' => 150],
            // [['ppa_value'], 'safe'],
            // [['cause_gender_issue'], 'required', 'when' => function ($model) { return $model->ppa_focused_id == 0; }],
            // [['budget_mooe','budget_ps','budget_co'],Yii::$app->controller->action->id == "create-gad-plan-budget" ? 'required' : 'safe',  'when' => function ($model) { return $model->budget_mooe == null && $model->budget_ps == null && $model->budget_co == null; }, 'message' => 'Please fill up atleast 1 from MOOE, PS, & CO '],
            // [['gi_sup_data'],  
            // Yii::$app->controller->id == "plan" || 
            // Yii::$app->controller->action->id == "create-gad-plan-budget" || 
            // Yii::$app->controller->action->id == "update-gender-issue-sup-data" ? 'required' : "safe", 'when' => function ($model) { return $model->inner_category_id == 1; }],
            // [['ppa_value'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'performance_indicator' => 'Performance  Indicator',
            'ppa_value' => 'Title/Description of Gender Issue or GAD Mandate',
            'ppa_focused_id' => 'Activity Category',
            // 'focused_id' => 'Category of PPAs',
            'cause_gender_issue' => 'Other Activity Category',
            'objective' => 'GAD  Objective',
            'relevant_lgu_program_project' => 'Relevant LGU Program or Project',
            'activity' => 'GAD Activity',
            'performance_target' => 'Performance Indicator and Target',
            'budget_mooe' => 'MOOE',
            'budget_ps' => 'PS',
            'budget_co' => 'CO',
            'lead_responsible_office' => 'Lead Responsible Office',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
            'date_updated' => 'Date Updated',
            'time_updated' => 'Time Updated',
            'sort' => 'Sort',
            'tuc_parent' => 'Tuc Parent',
            'focused_id' => 'Focused',
            'inner_category_id' => 'Gender Issue or GAD Mandate',
            'cliorg_ppa_attributed_program_id' => 'PPA Sectors',
            'gi_sup_data' => 'Gender Issue Supporting Statistics Data',
            'date_implement_start' => 'Target Date of Implementation',
            'activity_category_id' => 'Activity Category',
        ];
    }
}
