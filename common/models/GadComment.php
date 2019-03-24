<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_comment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $record_id
 * @property string $record_tuc
 * @property int $plan_budget_id
 * @property string $plan_budget_tuc
 * @property string $region_c
 * @property string $province_c
 * @property string $citymun_c
 * @property string $comment
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
            [['user_id', 'record_id', 'plan_budget_id','office_c'], 'integer'],
            [['plan_budget_id'], 'required'],
            [['comment'], 'string'],
            [['date_created', 'date_updated'], 'safe'],
            [['record_tuc', 'plan_budget_tuc'], 'string', 'max' => 100],
            [['region_c', 'province_c', 'citymun_c'], 'string', 'max' => 2],
            [['attribute_name'], 'string', 'max' => 150],
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
            'user_id' => 'User ID',
            'record_id' => 'Record ID',
            'record_tuc' => 'Record Tuc',
            'plan_budget_id' => 'Plan Budget ID',
            'plan_budget_tuc' => 'Plan Budget Tuc',
            'region_c' => 'Region C',
            'province_c' => 'Province C',
            'citymun_c' => 'Citymun C',
            'comment' => 'Comment',
            'attribute_name' => 'Attribute Name',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
            'date_updated' => 'Date Updated',
            'time_updated' => 'Time Updated',
        ];
    }
}
