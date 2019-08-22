<?php

namespace common\modules\rms\models;

use Yii;

/**
 * This is the model class for table "bpls_uploaded_client".
 *
 * @property int $id
 * @property int $user_id
 * @property string $region_c
 * @property string $province_c
 * @property string $citymun_c
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $application_no
 * @property string $business_name
 * @property string $business_tin
 * @property string $application_date
 * @property string $date_uploaded
 * @property int $business_type
 *
 * @property BplsBusinessType $businessType
 */
class UploadedClient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bpls_uploaded_client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['application_no', 'business_name','business_tin','application_date'], 'required'],
            // [['application_no'], 'unique', 'message' => 'Duplicate Business Permit Found'],
            // [['business_tin'], 'unique', 'message' => 'Duplicate TIN Found'],
            [['user_id', 'business_type'], 'integer'],
            [['date_uploaded'], 'safe'],
            [['business_type'], 'required'],
            [['region_c', 'province_c'], 'string', 'max' => 2],
            [['citymun_c'], 'string', 'max' => 3],
            [['first_name', 'middle_name', 'last_name', 'application_no', 'business_name'], 'string', 'max' => 150],
            // [['business_tin'], 'string', 'max' => 50],
            [['business_type'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessType::className(), 'targetAttribute' => ['business_type' => 'id']],
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
            'region_c' => 'Region C',
            'province_c' => 'Province C',
            'citymun_c' => 'Citymun C',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'application_no' => 'Permit No.',
            'business_name' => "Owner's Name / Company Name",
            'business_tin' => 'DTI/SEC/CDA No.',
            'application_date' => 'Date of registration',
            'date_uploaded' => 'Date Added',
            'business_type' => 'Type',
            'businessType.description' => 'Type'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessType()
    {
        return $this->hasOne(BusinessType::className(), ['id' => 'business_type']);
    }
}
