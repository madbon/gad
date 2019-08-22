<?php

namespace common\modules\rms\models;

use Yii;

/**
 * This is the model class for table "lgup_remarks".
 *
 * @property int $id
 * @property int $record_id
 * @property string $remarks
 * @property string $date
 */
class Remarks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bpls_remarks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['record_id', 'remarks', 'date'], 'required'],
            [['record_id'], 'integer'],
            [['remarks'], 'string'],
            [['date'], 'safe'],
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
            'remarks' => 'Remarks',
            'date' => 'Date',
        ];
    }
}
