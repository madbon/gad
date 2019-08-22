<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "tblinformation_latlng".
 *
 * @property int $location_id
 * @property string $region_c
 * @property string $province_c
 * @property string $citymun_c
 * @property string $lat
 * @property string $lng
 */
class PsgcCoordinators extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tblinformation_latlng';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_c', 'province_c', 'lat', 'lng'], 'required'],
            [['region_c', 'province_c'], 'string', 'max' => 2],
            [['citymun_c'], 'string', 'max' => 3],
            [['lat', 'lng'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'location_id' => 'Location ID',
            'region_c' => 'Region C',
            'province_c' => 'Province C',
            'citymun_c' => 'Citymun C',
            'lat' => 'Lat',
            'lng' => 'Lng',
        ];
    }
}
