<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_frequency".
 *
 * @property integer $id
 * @property string $title
 * @property integer $count
 *
 * @property cmsFrequencyDetails[] $cmsFrequencyDetails
 */
class Frequency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gad_cms_frequency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'count'], 'required'],
            [['count'], 'integer'],
            [['title'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'count' => 'Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrequencyDetails()
    {
        return $this->hasMany(FrequencyDetails::className(), ['frequency_id' => 'id']);
    }
}
