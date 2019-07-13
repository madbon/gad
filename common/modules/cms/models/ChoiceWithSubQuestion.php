<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_choice_with_subquestion".
 *
 * @property integer $id
 * @property integer $indicator_id
 * @property string $answer
 *
 * @property cmsIndicator $indicator
 */
class ChoiceWithSubQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gad_cms_choice_with_subquestion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['indicator_id'], 'integer'],
            [['answer'], 'required'],
            [['answer'], 'string', 'max' => 200],
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
            'answer' => 'Answer',
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
