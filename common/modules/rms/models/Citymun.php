<?php

namespace common\modules\dynamicview\models;

use Yii;
use common\modules\rms\models\Barangay;

/**
 * This is the model class for table "tblcitymun".
 *
 * @property string $region_c
 * @property string $province_c
 * @property string $district_c
 * @property string $citymun_c
 * @property string $citymun_m
 * @property string $lgu_type
 */
class Citymun extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public $place;
    public $region_name;
    public $choose_prov_city;
    public static function tableName()
    {
        return 'tblcitymun';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_c', 'province_c', 'district_c', 'citymun_c', 'citymun_m', 'lgu_type'], 'required'],
            [['region_c', 'province_c', 'citymun_c','region_name'], 'string', 'max' => 2],
            [['district_c','place'], 'string', 'max' => 3],
            [['citymun_m'], 'string', 'max' => 200],
            [['lgu_type'], 'string', 'max' => 1],
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
            'district_c' => 'District C',
            'citymun_c' => 'Citymun C',
            'citymun_m' => 'Citymun M',
            'lgu_type' => 'Lgu Type',
            'region_name' => 'Reg',
        ];
    }

    public function getFullPlace(){
        return $this->citymun->citymun_m.", ".$this->province->province_m.", ".$this->region->region_m;
    }

    public static function primaryKey(){
        return array('region_c','province_c','citymun_c');
    }

    public function getProvince(){
        return $this->hasOne(Province::className(), ['province_c' => 'province_c']);
    }

    public function getRegion(){
        return $this->hasOne(Region::className(), ['region_c' => 'region_c']);
    }

    public function getCitymun(){
        return $this->hasOne(Citymun::className(), ['region_c' => 'region_c','province_c' => 'province_c','citymun_c' => 'citymun_c']);
    }

    public function getClusterprovince(){
        return $this->hasOne(ClusterLevel::className(), ['province_c' => 'province_c']);
    }
    public function getBarangays(){
        return $this->hasMany(Barangay::className(), ['region_c'=>'region_c','province_c'=>'province_c','citymun_c'=>'citymun_c']);
    }

}
