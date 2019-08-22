<?php

namespace common\modules\cms\models;

use Yii;
use common\modules\cms\models\BarangayProfile;
/**
 * This is the model class for table "tblregion".
 *
 * @property string $region_c
 * @property string $region_m
 * @property string $abbreviation
 * @property integer $region_sort
 *
 * @property Form[] $forms
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
            'region_c' => 'Region C',
            'region_m' => 'Region M',
            'abbreviation' => 'Abbreviation',
            'region_sort' => 'Region Sort',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForms()
    {
        return $this->hasMany(Form::className(), ['REGION_C' => 'region_c']);
    }

    public function getDataByRegionPerStatus($status, $region)
    {
        $items = $this->getForms();
        $conditions = [];
        if(!empty($region)){ $conditions['REGION_C'] = $region; }
        if(!empty($status)){ $conditions['status_id'] = $status; }

        $items = $items->where($conditions)->all();

        return $items;
    }

    public function getBarangayProfiles()
    {
        $y = date('Y', strtotime(date('Y-m-d H:i:s')));
        return BarangayProfile::find()->where(['region_c' => $this->region_c, 'year' => $y])->all();
    }
}
