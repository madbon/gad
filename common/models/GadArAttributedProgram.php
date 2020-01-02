<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_ar_attributed_program".
 *
 * @property int $id
 * @property int $record_id
 * @property string $record_tuc
 * @property string $controller_id
 * @property int $ppa_attributed_program_id
 * @property string $ppa_attributed_program_others
 * @property string $lgu_program_project
 * @property string $hgdg_pimme
 * @property string $total_annual_pro_cost
 * @property string $gad_attributed_pro_cost
 * @property string $variance_remarks
 * @property string $date_created
 * @property string $time_created
 * @property string $date_updated
 * @property string $time_updated
 */
class GadArAttributedProgram extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_ar_attributed_program';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['record_id'], 'integer'],
            // [['lgu_program_project','ppa_attributed_program_id'],'required'],
            [['ppa_attributed_program_others', 'lgu_program_project', 'ar_ap_variance_remarks'], 'string'],
            [['total_annual_pro_cost', 'gad_attributed_pro_cost','hgdg_pimme'], 'number'],
            [['date_created', 'date_updated','plan_type_code'], 'safe'],
            [['record_tuc', 'controller_id'], 'string', 'max' => 150],
            [['time_created', 'time_updated'], 'string', 'max' => 10],

            [['ppa_attributed_program_id','lgu_program_project','hgdg_pimme','total_annual_pro_cost','ar_ap_variance_remarks','checklist_id','score_type'], Yii::$app->controller->action->id == "create-ar-attributed-program" || Yii::$app->controller->id == "accomplishment-attributed" ? 'required' : 'safe'],

            [['lgu_program_project'],Yii::$app->controller->action->id == "update-ar-ap-lgu-program-project" ? 'required' : 'safe'],

            [['hgdg_pimme'],Yii::$app->controller->action->id == "update-ar-hgdg-pimme" ? 'required' : 'safe'],

            [['total_annual_pro_cost'],Yii::$app->controller->action->id == "update-ar-total-annual-pro-cost" ? 'required' : 'safe'],

            [['ar_ap_variance_remarks'],Yii::$app->controller->action->id == "update-ar-variance-remarks" ? 'required' : 'safe'],
            // [['ppa_attributed_program_others'],'required', 'when' => function ($model) { return $model->ppa_attributed_program_id == 0; }]
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
            'controller_id' => 'Controller ID',
            'ppa_attributed_program_id' => 'PPA Sectors',
            'ppa_attributed_program_others' => 'Other PPA Attributed Program',
            'lgu_program_project' => 'Title of LGU Program or Project',
            'hgdg_pimme' => 'HGDG PIMME / FIMME Score',
            'total_annual_pro_cost' => 'Total Annual Program / Project Cost or Expenditure',
            'gad_attributed_pro_cost' => 'GAD Attributed Program / Project Cost or Expenditure',
            'ar_ap_variance_remarks' => 'Variance or Remarks',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
            'date_updated' => 'Date Updated',
            'time_updated' => 'Time Updated',
            'checklist_id' => 'Checklist',
        ];
    }
}
