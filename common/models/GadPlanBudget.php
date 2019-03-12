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
 * @property string $issue_mandate
 * @property string $objective
 * @property string $relevant_lgu_program_project
 * @property string $activity
 * @property string $performance_indicator_target
 * @property string $budget_mooe
 * @property string $budget_ps
 * @property string $budget_co
 * @property int $lead_responsible_office_id
 * @property string $date_created
 * @property string $time_created
 * @property string $date_updated
 * @property string $time_updated
 * @property string $sort
 * @property string $tuc_parent
 */
class GadPlanBudget extends \yii\db\ActiveRecord
{
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
            [['lead_responsible_office_id','focused_id','issue_or_mandate','user_id'], 'integer'],
            [['issue_mandate', 'objective', 'relevant_lgu_program_project', 'activity', 'performance_indicator_target'], 'string'],
            [['budget_mooe', 'budget_ps', 'budget_co', 'sort'], 'number'],
            // [['issue_mandate','ppa_value','objective','relevant_lgu_program_project','activity','performance_indicator_target'], 'required'],
            [['issue_mandate','ppa_value'], 'required'],
            [['date_created', 'date_updated'], 'safe'],
            [['time_created', 'time_updated'], 'string', 'max' => 10],
            [['record_tuc','tuc'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'issue_mandate' => 'Issue Mandate',
            'objective' => 'Objective',
            'relevant_lgu_program_project' => 'Relevant Lgu Program Project',
            'activity' => 'Activity',
            'performance_indicator_target' => 'Performance Indicator Target',
            'budget_mooe' => 'Budget Mooe',
            'budget_ps' => 'Budget Ps',
            'budget_co' => 'Budget Co',
            'lead_responsible_office_id' => 'Lead Responsible Office ID',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
            'date_updated' => 'Date Updated',
            'time_updated' => 'Time Updated',
            'sort' => 'Sort',
            'tuc_parent' => 'Tuc Parent',
        ];
    }
}
