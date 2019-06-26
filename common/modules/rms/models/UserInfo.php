<?php

namespace common\modules\rms\models;

use Yii;

/**
 * This is the model class for table "user_info".
 *
 * @property int $user_id
 * @property string $EMP_N
 * @property string $LAST_M
 * @property string $FIRST_M
 * @property string $MIDDLE_M
 * @property string $SUFFIX
 * @property string $BIRTH_D
 * @property string $SEX_C
 * @property int $OFFICE_C
 * @property int $DIVISION_C
 * @property int $SECTION_C
 * @property int $POSITION_C
 * @property int $DESIGNATION
 * @property string $REGION_C
 * @property string $PROVINCE_C
 * @property string $CITYMUN_C
 * @property string $MOBILEPHONE
 * @property string $LANDPHONE
 * @property string $FAX_NO
 * @property string $EMAIL
 * @property string $PHOTO
 * @property string $ALTER_EMAIL
 * @property string $BARANGAY_C
 * @property string $EMP_STATUS
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LAST_M', 'FIRST_M', 'MIDDLE_M', 'SUFFIX', 'BIRTH_D', 'SEX_C', 'OFFICE_C', 'REGION_C', 'PROVINCE_C', 'CITYMUN_C', 'MOBILEPHONE'], 'required'],
            [['BIRTH_D'], 'safe'],
            [['OFFICE_C', 'DIVISION_C', 'SECTION_C', 'POSITION_C', 'DESIGNATION'], 'integer'],
            [['EMP_N', 'EMAIL', 'PHOTO', 'ALTER_EMAIL'], 'string', 'max' => 100],
            [['LAST_M', 'FIRST_M', 'MIDDLE_M', 'SUFFIX'], 'string', 'max' => 255],
            [['SEX_C'], 'string', 'max' => 7],
            [['REGION_C', 'PROVINCE_C', 'EMP_STATUS'], 'string', 'max' => 2],
            [['CITYMUN_C', 'BARANGAY_C'], 'string', 'max' => 3],
            [['MOBILEPHONE', 'LANDPHONE', 'FAX_NO'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'EMP_N' => 'Emp  N',
            'LAST_M' => 'Last  M',
            'FIRST_M' => 'First  M',
            'MIDDLE_M' => 'Middle  M',
            'SUFFIX' => 'Suffix',
            'BIRTH_D' => 'Birth  D',
            'SEX_C' => 'Sex  C',
            'OFFICE_C' => 'Office  C',
            'DIVISION_C' => 'Division  C',
            'SECTION_C' => 'Section  C',
            'POSITION_C' => 'Position  C',
            'DESIGNATION' => 'Designation',
            'REGION_C' => 'Region  C',
            'PROVINCE_C' => 'Province  C',
            'CITYMUN_C' => 'Citymun  C',
            'MOBILEPHONE' => 'Mobilephone',
            'LANDPHONE' => 'Landphone',
            'FAX_NO' => 'Fax  No',
            'EMAIL' => 'Email',
            'PHOTO' => 'Photo',
            'ALTER_EMAIL' => 'Alter  Email',
            'BARANGAY_C' => 'Barangay  C',
            'EMP_STATUS' => 'Emp  Status',
        ];
    }

    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['region_c' => 'REGION_C']);
    }

    // get region name 
    public function getRegionName()
    {
        return $this->region ? $this->region->region_m : "" ;
    }

    // get abbreviation of region name
    public function getRegionNameShort()
    {  
        return $this->region ? $this->region->abbreviation : "" ;
    }

    // relation with province - @return \yii\db\ActiveQuery
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['province_c' => 'PROVINCE_C']);
    }

    // get province name 
    public function getProvinceName()
    {   
        return $this->province ? $this->province->province_m : "" ;
    }

    // relation with citymun - @return \yii\db\ActiveQuery
    public function getCitymun()
    {
        if($this->REGION_C == 13 && $this->PROVINCE_C == 39){
            $qry = $this->hasOne(Citymun::className(), ['REGION_C'=>'region_c','PROVINCE_C' => 'province_c']);
        } else {
            $qry = $this->hasOne(Citymun::className(), ['PROVINCE_C' => 'province_c','CITYMUN_C'=>'citymun_c']);
        }
        return $qry;
    }

    // get citymun name 
    public function getCitymunName()
    {   
       $CityMun = $this->REGION_C == 13 && $this->PROVINCE_C == 39 ? "MANILA" : Citymun::findOne(['province_c' => $this->PROVINCE_C,'citymun_c'=> $this->CITYMUN_C])->citymun_m;
        return  $CityMun;
    }

}
