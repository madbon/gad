<?php

namespace common\modules\cms\models;

use Yii;
use common\modules\cms\models\Form;
use common\modules\cms\models\Region;
use common\modules\cms\models\Province;  
use common\modules\cms\models\BarangayData;
use niksko12\auditlogs\classes\ModelAudit;

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
class CityMunicipality extends ModelAudit
{
    /**
     * @inheritdoc
     */

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
            [['region_c', 'province_c', 'citymun_c'], 'string', 'max' => 2],
            [['district_c', 'lgu_type'], 'string', 'max' => 3],
            [['citymun_m'], 'string', 'max' => 200],
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
        ];
    }

    public function getForms()
    {
        return $this->hasMany(Form::className(), ['CITYMUN_C' => 'citymun_c', 'PROVINCE_C' => 'province_c']);
    }

    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['region_c' => 'region_c']);
    }

    /**
     * @return string | Region Name
     */
    public function getRegionName()
    {
        return $this->region->region_m;
    }

    /**
     * @return string | Region Short
     */
    public function getRegionNameShort()
    {
        return $this->region->abbreviation;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['province_c' => 'province_c']);
    }

    /**
     * @return string | Province Name
     */
    public function getProvinceName()
    {
        return $this->province->province_m;
    }


    public function getCitymunName(){    
            return $this->citymun_m;
    }

    public function getFormsPerCitymunAndYear($province, $citymun, $year)
    {
        return Form::find()->where(['PROVINCE_C' => $province, 'CITYMUN_C' => $citymun,'year' => $year])->all();
    }


    public function getFormsPerProvinceAndYear($region, $province, $year)
    {
        return Form::find()->where(['REGION_C' => $region, 'PROVINCE_C' => $province, 'year' => $year])->all();
    }

    public function getFormsPerRegionAndYear($region, $year)
    {
        return Form::find()->where(['REGION_C' => $region, 'year' => $year])->all();
    }

    public function getCitymuns($province, $year)
    {
        return Form::find()->where(['PROVINCE_C' => $province, 'year' => $year])->groupBy(['citymun_c'])->all();
    }


    public function getOneCitymun($province, $citymun, $year)
    {
        return Form::find()->where(['PROVINCE_C' => $province, 'CITYMUN_C' => $citymun, 'year' => $year])->groupBy(['citymun_c'])->all();
    }

    public function getProvinces($region, $year)
    {
        return Form::find()->where(['REGION_C' => $region, 'year' => $year])->groupBy(['province_c'])->all();
    }

    public function getRegions($year)
    {
        return Form::find()->where(['year' => $year])->groupBy(['REGION_C'])->all();
    }

    public function getDataByCitymunPerStatus($status, $citymun)
    {
        $items = $this->getForms();
        $conditions = [];
        if(!empty($citymun)){ $conditions['CITYMUN_C'] = $citymun; }
        if(!empty($status)){ $conditions['status_id'] = $status; }

        $items = $items->where($conditions)->all();

        return $items;
    }

    public function getBarangayProfiles()
    {
        $y = date('Y', strtotime(date('Y-m-d H:i:s')));
        return BarangayProfile::find()->where(['citymun_c' => $this->citymun_c, 'province_c' => $this->province_c, 'year' => $y])->all();
    }
}
