<?php

namespace common\modules\rms\models;

use Yii;
use common\modules\rms\models\Citymun;
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfos()
    {
        return $this->hasMany(UserInfo::className(), ['PROVINCE_C' => 'province_c']);
    }


    public function getCitymuns(){
        return $this->hasMany(Citymun::className(), ['region_c'=>'region_c','province_c'=>'province_c']);
    }

    public function getRegion(){
        return $this->hasOne(Region::className(), ['region_c'=>'region_c']);
    }

    public function getClustercitymuns(){
        return $this->hasMany(ClusterLevel::className(), ['province_c'=>'province_c']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangays()
    {
        return $this->hasMany(Barangay::className(), ['region_c' => 'region_c', 'province_c'=>'province_c']);
    }
}
