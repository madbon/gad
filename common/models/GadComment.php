<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_comment".
 *
 * @property int $id
 * @property int $resp_user_id
 * @property int $resp_office_c
 * @property int $record_id
 * @property int $plan_budget_id
 * @property string $resp_region_c
 * @property string $resp_province_c
 * @property string $resp_citymun_c
 * @property string $comment
 * @property int $row_no
 * @property int $column_no
 * @property string $row_value
 * @property string $column_value
 * @property string $model_name
 * @property string $attribute_name
 * @property string $date_created
 * @property string $time_created
 * @property string $date_updated
 * @property string $time_updated
 */
class GadComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $record_tuc;
    public static function tableName()
    {
        return 'gad_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resp_user_id', 'resp_office_c', 'record_id', 'plan_budget_id', 'row_no', 'column_no'], 'integer'],
            [['row_no', 'column_no', 'row_value', 'column_value','comment'], 'required'],
            [['comment', 'row_value', 'column_value'], 'string'],
            [['date_created', 'date_updated','record_tuc'], 'safe'],
            [['resp_region_c', 'resp_province_c', 'resp_citymun_c'], 'string', 'max' => 2],
            [['model_name', 'attribute_name'], 'string', 'max' => 150],
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
            'resp_user_id' => 'Resp User ID',
            'resp_office_c' => 'Resp Office C',
            'record_id' => 'Record ID',
            'plan_budget_id' => 'Plan Budget ID',
            'resp_region_c' => 'Resp Region C',
            'resp_province_c' => 'Resp Province C',
            'resp_citymun_c' => 'Resp Citymun C',
            'comment' => 'Observation & Recommendation',
            'row_no' => 'Row No.',
            'column_no' => 'Column No.',
            'row_value' => 'Row Value',
            'column_value' => 'Column Value',
            'model_name' => 'Model Name',
            'attribute_name' => 'Attribute Name',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
            'date_updated' => 'Date Updated',
            'time_updated' => 'Time Updated',
        ];
    }
}
