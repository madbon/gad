<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_report_history".
 *
 * @property int $id
 * @property string $remarks
 * @property string $tuc
 * @property int $status
 * @property string $date_created
 * @property string $time_created
 */
class GadReportHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_report_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['remarks'], 'string'],
            [['status'], 'integer'],
            [['date_created', 'time_created','responsible_office_c','responsible_user_id'], 'safe'],
            [['tuc'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'remarks' => 'Remarks',
            'tuc' => 'Tuc',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
        ];
    }
}
