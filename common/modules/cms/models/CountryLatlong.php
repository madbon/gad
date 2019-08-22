<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "country_latlong".
 *
 * @property int $id
 * @property string $acronym
 * @property string $latitude
 * @property string $longitude
 * @property string $country_name
 */
class CountryLatlong extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country_latlong';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['acronym', 'latitude', 'longitude', 'country_name'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'acronym' => 'Acronym',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'country_name' => 'Country Name',
        ];
    }
}
