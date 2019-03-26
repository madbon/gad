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
            [['cause_gender_issue', 'objective', 'relevant_lgu_program_project', 'activity', 'performance_target','performance_indicator'], 'string'],
            [['budget_mooe', 'budget_ps', 'budget_co', 'sort'], 'number'],
            // [['cause_gender_issue','ppa_value','objective','relevant_lgu_program_project','activity','performance_target'], 'required'],
            [['cause_gender_issue','ppa_focused_id','inner_category_id','focused_id'], 'required'],
            [['date_created', 'date_updated'], 'safe'],
            [['time_created', 'time_updated'], 'string', 'max' => 10],
            [['record_tuc','tuc'], 'string', 'max' => 150],
            // [['ppa_value'], 'safe'],
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
            'performance_indicator' => 'Performance  Indicator',
            'ppa_value' => 'PPA Other Description',
            'ppa_focused_id' => 'Category of PPA',
            // 'focused_id' => 'Category of PPAs',
            'cause_gender_issue' => 'Gender Issue or GAD Mandate',
            'objective' => 'GAD  Objective',
            'relevant_lgu_program_project' => 'Relevant LGU Program or Project',
            'activity' => 'GAD Activity',
            'performance_target' => 'Performance Target',
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
            'inner_category_id' => 'Gender Issue or GAD Mandate'
        ];
    }
}
