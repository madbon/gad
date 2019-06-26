<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "tblprovince".
 *
 * @property string $region_c
 * @property string $province_c
 * @property string $province_m
 *
 * @property UserInfo[] $userInfos
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tblprovince';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_c', 'province_c', 'province_m'], 'required'],
            [['region_c', 'province_c'], 'string', 'max' => 2],
            [['province_m'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_c' => 'Region C',
            'province_c' => 'Province C',
            'province_m' => 'Province M',
        ];
    }

    public function getForms()
    {
        return $this->hasMany(Form::className(), ['REGION_C' => 'region_c', 'PROVINCE_C' => 'province_c']);
    }

    public function getCitymuns(){
        return $this->hasMany(CityMunicipality::className(), ['province_c'=>'province_c']);
    }

    public function getRegion(){
        return $this->hasOne(Region::className(), ['region_c'=>'region_c']);
    }

    public function getDataByProvincePerStatus($status, $province)
    {
        $items = $this->getForms();
        $conditions = [];
        if(!empty($province)){ $conditions['PROVINCE_C'] = $province; }
        if(!empty($status)){ $conditions['status_id'] = $status; }

        $items = $items->where($conditions)->all();

        return $items;
    }

    public function getBarangayProfiles()
    {
        $y = date('Y', strtotime(date('Y-m-d H:i:s')));
        return BarangayProfile::find()->where(['region_c' => $this->region_c, 'province_c' => $this->province_c, 'year' => $y])->all();
    }
    
}
