<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_sub_question_value".
 *
 * @property integer $id
 * @property integer $values_id
 * @property integer $sub_question_id
 * @property string $sub_question_value
 *
 * @property cmsValues $values
 * @property cmsSubQuestion $subQuestion
 */
class SubQuestionValue extends \yii\db\ActiveRecord
{
    public $indicator_id;
    public $type;
    public $sub_question;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_sub_question_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['values_id', 'sub_question_id'], 'integer'],
            //[['sub_question_id', 'sub_question_value'], 'required'],
            [['sub_question_value'], 'string', 'max' => 150],
            [['values_id'], 'exist', 'skipOnError' => true, 'targetClass' => Value::className(), 'targetAttribute' => ['values_id' => 'id']],
            [['sub_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubQuestion::className(), 'targetAttribute' => ['sub_question_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'values_id' => 'Values ID',
            'sub_question_id' => 'Sub Question ID',
            'sub_question_value' => 'Sub Question Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasOne(Value::className(), ['id' => 'values_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubQuestion()
    {
        return $this->hasOne(SubQuestion::className(), ['id' => 'sub_question_id']);
    }
}
