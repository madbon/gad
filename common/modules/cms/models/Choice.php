<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_ind_choices".
 *
 * @property integer $id
 * @property integer $indicator_id
 * @property string $value
 *
 * @property cmsIndicators $indicator
 */
class Choice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gad_cms_ind_choices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['indicator_id','default_choice_id'], 'integer'],
            // [['indicator_id'], 'required'],
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
            'indicator_id' => 'Indicator',
            'default_choice_id' => 'Default Choice',
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
