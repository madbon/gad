<?php

namespace common\modules\rms\models;

use Yii;

/**
 * This is the model class for table "bis_ind_choices".
 *
 * @property integer $id
 * @property integer $indicator_id
 * @property string $value
 *
 * @property BisIndicators $indicator
 */
class Choice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bpls_ind_choices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['indicator_id'], 'integer'],
            //[['value'], 'required'],
            [['value'], 'string', 'max' => 300],
            [['indicator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Indicator::className(), 'targetAttribute' => ['indicator_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'indicator_id' => 'Indicator ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicator()
    {
        return $this->hasOne(Indicator::className(), ['id' => 'indicator_id']);
    }
}
