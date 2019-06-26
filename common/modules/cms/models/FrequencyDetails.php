<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_frequency_details".
 *
 * @property integer $id
 * @property integer $frequency_id
 * @property string $details
 *
 * @property cmsFrequency $frequency
 */
class FrequencyDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bpls_frequency_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frequency_id', 'details'], 'required'],
            [['frequency_id'], 'integer'],
            [['details'], 'string', 'max' => 100],
            [['frequency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Frequency::className(), 'targetAttribute' => ['frequency_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'frequency_id' => 'Frequency ID',
            'details' => 'Details',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrequency()
    {
        return $this->hasOne(Frequency::className(), ['id' => 'frequency_id']);
    }
}
