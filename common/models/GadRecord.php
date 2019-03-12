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
            [['user_id', 'year', 'form_type', 'status', 'is_archive'], 'integer'],
            [['total_lgu_budget', 'total_gad_budget'], 'number'],
            [['date_created'], 'safe'],
            [['time_created'], 'string', 'max' => 10],
            [['region_c', 'province_c', 'citymun_c'], 'string', 'max' => 2],
            [['tuc'], 'string', 'max' => 150],
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
            'total_gad_budget' => 'Total GAD Budget',
            'year' => 'Year',
            'form_type' => 'Form Type',
            'status' => 'Status',
            'is_archive' => 'Is Archive',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
        ];
    }
}
