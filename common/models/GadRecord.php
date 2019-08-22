<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_record".
 *
 * @property int $id
 * @property int $user_id
 * @property int $region_c
 * @property int $province_c
 * @property int $citymun_c
 * @property string $total_lgu_budget
 * @property string $total_gad_budget
 * @property int $year
 * @property int $form_type
 * @property int $status
 * @property int $is_archive
 * @property string $date_created
 * @property string $time_created
 */
class GadRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    public static function tableName()
    {
        return 'gad_record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'form_type', 'status', 'is_archive','report_type_id','office_c','isdilg'], 'integer'],
            [['year','create_status_id'],'integer'],
            [['total_lgu_budget'], 'number'],
            [['date_created'], 'safe'],
            [['time_created'], 'string', 'max' => 10],
            [['region_c', 'province_c', 'citymun_c'], 'string', 'max' => 2],
            [['tuc','prepared_by','approved_by'], 'string', 'max' => 150],
            // [['year','total_lgu_budget','create_status_id'], 'required'],
            // [['create_status_id'], 'required'],
            [['prepared_by'], Yii::$app->controller->action->id == "update-pb-prepared-by" ? "required" : "safe"],
            [['approved_by'], Yii::$app->controller->action->id == "update-pb-approved-by" ? "required" : "safe"],
            [['footer_date'], Yii::$app->controller->action->id == "update-pb-footer-date" ? "required" : "safe"],
            // [['for_revision_record_id'], 'required','message' => 'Please select One(1) Returned Reports listed below ', 'when' => function ($model) { return $model->create_status_id != 1; }, 'whenClient' => "function (attribute, value) { return $('#gadrecord-create_status_id').val() != '1'; }"],
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
            'region_c' => 'Region',
            'province_c' => 'Province',
            'citymun_c' => 'Citymun',
            'total_lgu_budget' => 'Total LGU Budget',
            'year' => 'Year',
            'form_type' => 'Form Type',
            'status' => 'Status',
            'is_archive' => 'Is Archive',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
            'create_status_id' => 'Plan Category'
        ];
    }
}
