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
            [['ppa_value', 'cause_gender_issue', 'objective', 'relevant_lgu_ppa', 'activity', 'performance_indicator', 'target', 'actual_results', 'variance_remarks'], 'string'],
            [['total_approved_gad_budget', 'actual_cost_expenditure'], 'number'],
            [['date_created', 'date_updated'], 'safe'],
            [['focused_id', 'inner_category_id','ppa_focused_id'], 'required'],
            [['time_created', 'time_updated'], 'string', 'max' => 10],
            [['record_tuc', 'this_tuc'], 'string', 'max' => 150],
            [['ppa_value'], 'required', 'when' => function ($model) { return $model->ppa_focused_id == 0; }],
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
            'ppa_focused_id' => 'PPA Category',
            'ppa_value' => 'PPA Other Category',
            'cause_gender_issue' => 'Cause of the Gender Issue',
            'objective' => 'GAD Objective',
            'relevant_lgu_ppa' => 'Relevant LGU PPA',
            'activity' => 'GAD Activity',
            'performance_indicator' => 'Performance Indicator',
            'target' => 'Target',
            'actual_results' => 'Actual Results',
            'total_approved_gad_budget' => 'Total Approved GAD Budget',
            'actual_cost_expenditure' => 'Actual Cost or Expenditure',
            'variance_remarks' => 'Variance Remarks',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
            'date_updated' => 'Date Updated',
            'time_updated' => 'Time Updated',
            'record_tuc' => 'Record Tuc',
            'this_tuc' => 'This Tuc',
        ];
    }
}
