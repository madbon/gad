<?php

namespace common\modules\rms\models;

use Yii;
use common\modules\rms\models\Barangay;

/**
 * This is the model class for table "tblbarangay".
 *
 * @property string $region_c
 * @property string $province_c
 * @property string $citymun_c
 * @property string $barangay_c
 * @property string $district_c
 * @property string $barangay_m
 */
class Barangay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tblbarangay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_c', 'province_c', 'citymun_c', 'barangay_c', 'district_c', 'barangay_m'], 'required'],
            [['region_c', 'province_c', 'citymun_c'], 'string', 'max' => 2],
            [['barangay_c', 'district_c'], 'string', 'max' => 3],
            [['barangay_m'], 'string', 'max' => 200],
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
            'citymun_c' => 'Citymun C',
            'barangay_c' => 'Barangay C',
            'district_c' => 'District C',
            'barangay_m' => 'Barangay M',
        ];
    }

    public static function primaryKey(){
        return array('region_c','province_c','citymun_c','barangay_c');
    }

    public function getCitymun(){
        return $this->hasOne(Citymun::className(), ['province_c' => 'province_c','citymun_c'=>'citymun_c']);
    }

    public function getProvince(){
        return $this->hasOne(Province::className(), ['province_c' => 'province_c']);
    }

    public function getRegion(){
        return $this->hasOne(Region::className(), ['region_c' => 'region_c']);
    }

    public function getSum($indicator_id, $sub_question_id, $year){
        $total = Value::find()->where(['indicator_id' => $indicator_id, 'sub_question_id' => $sub_question_id])->leftJoin('da_barangay', 'da_barangay.id = bis_values.da_brgy_id')->andFilterWhere(['da_barangay.region_c' => $this->region_c, 'da_barangay.province_c' => $this->province_c, 'da_barangay.citymun_c' => $this->citymun_c, 'da_barangay.barangay_c' => $this->barangay_c, 'da_barangay.year' => $year])->sum('value');
        
        return $total;
    }
}
