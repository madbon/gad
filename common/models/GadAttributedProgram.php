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
            [['lgu_program_project', 'hgdg'], 'string'],
            [['total_annual_pro_budget', 'attributed_pro_budget'], 'number'],
            [['date_created', 'date_updated'], 'safe'],
            [['record_tuc', 'lead_responsible_office'], 'string', 'max' => 150],
            [['time_created', 'time_updated'], 'string', 'max' => 10],
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
            'lgu_program_project' => 'Lgu Program Project',
            'hgdg' => 'Hgdg',
            'total_annual_pro_budget' => 'Total Annual Pro Budget',
            'attributed_pro_budget' => 'Attributed Pro Budget',
            'lead_responsible_office' => 'Lead Responsible Office',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
            'date_updated' => 'Date Updated',
            'time_updated' => 'Time Updated',
        ];
    }
}
