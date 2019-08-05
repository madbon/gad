<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_accomplishment_report".
 *
 * @property int $id
 * @property int $user_id
 * @property int $record_id
 * @property int $focused_id
 * @property int $inner_category_id
 * @property int $ppa_focused_id
 * @property string $ppa_value
 * @property string $cause_gender_issue
 * @property string $objective
 * @property string $relevant_lgu_ppa
 * @property string $activity
 * @property string $performance_indicator
 * @property string $target
 * @property string $actual_results
 * @property string $total_approved_gad_budget
 * @property string $actual_cost_expenditure
 * @property string $variance_remarks
 * @property string $date_created
 * @property string $time_created
 * @property string $date_updated
 * @property string $time_updated
 * @property string $record_tuc
 * @property string $this_tuc
 */
class GadAccomplishmentReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_accomplishment_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'record_id', 'focused_id', 'inner_category_id', 'ppa_focused_id'], 'integer'],
            [['ppa_value', 'objective', 'relevant_lgu_ppa', 'activity', 'performance_indicator', 'actual_results', 'variance_remarks','gi_sup_data','cliorg_ppa_attributed_program_id'], 'string'],

            [['ppa_value','inner_category_id','focused_id', 'objective', 'relevant_lgu_ppa', 'activity','performance_indicator', 'actual_results', 'variance_remarks','cliorg_ppa_attributed_program_id','total_approved_gad_budget','actual_cost_expenditure'], Yii::$app->controller->action->id == "create-accomplishment-report" ? 'required' : 'safe'],
            [['total_approved_gad_budget', 'actual_cost_expenditure'], 'number'],
            [['date_created', 'date_updated'], 'safe'],
            [['activity_category_id'], 'required'],
            [['time_created', 'time_updated'], 'string', 'max' => 10],
            [['record_tuc', 'this_tuc'], 'string', 'max' => 150],
            [['ppa_value'],Yii::$app->controller->action->id == "update-ar-ppa-value" ? 'required' : 'safe'],
            [['objective'],Yii::$app->controller->action->id == "upd8-ar-gad-objective" ? 'required' : 'safe'],
            [['relevant_lgu_ppa'],Yii::$app->controller->action->id == "upd8-ar-relevant-lgu-ppa" ? 'required' : 'safe'],
            [['activity'],Yii::$app->controller->action->id == "upd8-ar-gad-activity" ? 'required' : 'safe'],
            [['performance_indicator'],Yii::$app->controller->action->id == "upd8-ar-performance-indicator" ? 'required' : 'safe'],
            [['total_approved_gad_budget'],Yii::$app->controller->action->id == "upd8-ar-total-approved-gad-budget" ? 'required' : 'safe'],
            [['actual_cost_expenditure'],Yii::$app->controller->action->id == "upd8-ar-actual-cost-expenditure" ? 'required' : 'safe'],
            [['variance_remarks'],Yii::$app->controller->action->id == "upd8-ar-variance-remark" ? 'required' : 'safe'],
            [['gi_sup_data'],  
            Yii::$app->controller->action->id == "create-accomplishment-report" || 
            Yii::$app->controller->action->id == "update-ar-gender-issue-sup-data" ? 'required' : "safe", 'when' => function ($model) { return $model->inner_category_id == 1; }],
            // [['cause_gender_issue'], 'required', 'when' => function ($model) { return $model->ppa_focused_id == 0; }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'record_id' => 'Record ID',
            'focused_id' => 'Focused',
            'inner_category_id' => 'Gender Issue or GAD Mandate',
            'ppa_focused_id' => 'Activity Category',
            'ppa_value' => 'Title / Description of Gender Issue or GAD Mandate',
            'cause_gender_issue' => 'Activity Category Other Description',
            'objective' => 'GAD Objective',
            'relevant_lgu_ppa' => 'Relevant LGU PPA',
            'activity' => 'GAD Activity',
            'performance_indicator' => 'Performance Indicator and Target',
            'target' => 'Target',
            'actual_results' => 'Actual Results',
            'total_approved_gad_budget' => 'Approved GAD Budget',
            'actual_cost_expenditure' => 'Actual Cost or Expenditure',
            'variance_remarks' => 'Variance Remarks',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
            'date_updated' => 'Date Updated',
            'time_updated' => 'Time Updated',
            'record_tuc' => 'Record Tuc',
            'this_tuc' => 'This Tuc',
            'cliorg_ppa_attributed_program_id' => 'PPA Sectors',
            'gi_sup_data' => 'Gender Issue Supporting Statistics Data',
            'activity_category_id' => 'Activity Category'
        ];
    }
}
