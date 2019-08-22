<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_attributed_program".
 *
 * @property int $id
 * @property int $record_id
 * @property string $record_tuc
 * @property string $lgu_program_project
 * @property string $hgdg
 * @property string $total_annual_pro_budget
 * @property string $attributed_pro_budget
 * @property string $lead_responsible_office
 * @property string $date_created
 * @property string $time_created
 * @property string $date_updated
 * @property string $time_updated
 */
class GadAttributedProgram extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_attributed_program';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['record_id'], 'integer'],
            [['lgu_program_project'], 'string'],
            [['total_annual_pro_budget','hgdg'], 'number'],
            [['date_created', 'date_updated'], 'safe'],
            [['record_tuc', 'ap_lead_responsible_office'], 'string', 'max' => 150],
            [['time_created', 'time_updated'], 'string', 'max' => 10],
            [['lgu_program_project','ppa_attributed_program_id','hgdg','total_annual_pro_budget','ap_lead_responsible_office','checklist_id'],Yii::$app->controller->action->id == "create-pb-attributed-program" || Yii::$app->controller->id == "plan-attributed" ? 'required' : 'safe'],

            [['lgu_program_project'], Yii::$app->controller->action->id == "update-ap-lgu-program-project" ? "required" : "safe"],

            [['hgdg'], Yii::$app->controller->action->id == "update-hgdg" ? "required" : "safe"],

            [['total_annual_pro_budget'], Yii::$app->controller->action->id == "update-total-annual-pro-budget" ? "required" : "safe"],

            // [['attributed_pro_budget'], Yii::$app->controller->action->id == "update-attributed-pro-budget" ? "required" : "safe"],

            [['ap_lead_responsible_office'], Yii::$app->controller->action->id == "update-ap-lead-responsible-office" ? "required" : "safe"]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'record_id' => 'Record ID',
            'record_tuc' => 'Record Tuc',
            'ppa_attributed_program_others' => 'Other PPA Attributed Programs',
            'ppa_attributed_program_id' => 'PPA Sectors',
            'lgu_program_project' => 'Title of LGU Program or Project',
            'hgdg' => 'HGDG Design / Funding Facility Generic Checklist Score',
            'total_annual_pro_budget' => 'Total Annual Program / Project Budget',
            'attributed_pro_budget' => 'GAD Attributed Program / Project Budget',
            'ap_lead_responsible_office' => 'Lead or Responsible Office',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
            'date_updated' => 'Date Updated',
            'time_updated' => 'Time Updated',
            'checklist_id' => 'Checklist'
        ];
    }
}
