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
            
            [['record_id','ppa_attributed_program_id'], 'integer'],
            [['lgu_program_project', 'hgdg'], 'string'],
            [['total_annual_pro_budget', 'attributed_pro_budget'], 'number'],
            [['date_created', 'date_updated'], 'safe'],
            [['record_tuc', 'lead_responsible_office'], 'string', 'max' => 150],
            [['time_created', 'time_updated'], 'string', 'max' => 10],
            [['lgu_program_project','ppa_attributed_program_id'], 'required'],
            // [['ppa_attributed_program_id'],'required', 'when' => function ($model) { return $model->ppa_attributed_program_id == null; }],
            [['ppa_attributed_program_others'],'required', 'when' => function ($model) { return $model->ppa_attributed_program_id == 0; }]

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
            'ppa_attributed_program_id' => 'Category of PPA Attributed Programs',
            'lgu_program_project' => 'Title of LGU Program or Project',
            'hgdg' => 'HGDG Design / Funding Facility Generic Checklist Score',
            'total_annual_pro_budget' => 'Total Annual Program / Project Budget',
            'attributed_pro_budget' => 'GAD Attributed Program / Project Budget',
            'lead_responsible_office' => 'Lead or Responsible Office',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
            'date_updated' => 'Date Updated',
            'time_updated' => 'Time Updated',
        ];
    }
}
