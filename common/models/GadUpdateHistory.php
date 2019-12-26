<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_update_history".
 *
 * @property int $id
 * @property int $record_id
 * @property string $record_tuc
 * @property int $user_id
 * @property string $fullname
 * @property string $column_title
 * @property int $row_id
 * @property string $value
 * @property string $date_created
 * @property string $time_created
 */
class GadUpdateHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_update_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['record_id', 'user_id', 'row_id'], 'integer'],
            [['value'], 'safe'],
            [['date_created','model_name'], 'safe'],
            [['record_tuc'], 'safe', 'max' => 100],
            [['fullname'], 'safe', 'max' => 150],
            [['column_title'], 'safe', 'max' => 250],
            [['time_created'], 'safe', 'max' => 10],
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
            'user_id' => 'User ID',
            'fullname' => 'Fullname',
            'column_title' => 'Column Title',
            'row_id' => 'Row ID',
            'value' => 'Value',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
        ];
    }
}
