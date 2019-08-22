<?php

namespace common\modules\rms\models;

use Yii;
use common\modules\rms\models\DrugAffectationBarangay;
use common\modules\rms\models\Province;
use common\modules\rms\models\Barangay;

/**
 * This is the model class for table "tblregion".
 *
 * @property string $region_c
 * @property string $region_m
 * @property string $abbreviation
 * @property integer $region_sort
 *
 * @property UserInfo[] $userInfos
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tblregion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_c', 'region_m', 'abbreviation'], 'required'],
            [['region_sort'], 'integer'],
            [['region_c'], 'string', 'max' => 2],
            [['region_m', 'abbreviation'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_c' => 'Region',
            'region_m' => 'Region',
            'abbreviation' => 'Abbreviation',
            'region_sort' => 'Region Sort',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfos()
    {
        return $this->hasMany(UserInfo::className(), ['REGION_C' => 'region_c']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrugAffectationBarangays()
    {
        return $this->hasMany(DrugAffectationBarangay::className(), ['region_c' => 'region_c']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvinces()
    {
        return $this->hasMany(Province::className(), ['region_c' => 'region_c']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangays()
    {
        return $this->hasMany(Barangay::className(), ['region_c' => 'region_c']);
    }
}
