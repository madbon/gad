<?php

namespace common\modules\cms\models;

use Yii;
use common\modules\cms\models\Value;

/**
 * This is the model class for table "cms_sub_question".
 *
 * @property integer $id
 * @property integer $indicator_id
 * @property string $compare_value
 * @property string $sub_question
 * @property string $type
 *
 * @property cmsIndicators $indicator
 */
class SubQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bpls_sub_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['indicator_id'], 'integer'],
            [['sub_question', 'type'], 'required'],
            [['sub_question'], 'string', 'max' => 1000],
            [['type'], 'string', 'max' => 500],
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
            'sub_question' => 'Sub Question',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicator()
    {
        return $this->hasOne(Indicator::className(), ['id' => 'indicator_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeId()
    {
        return $this->hasOne(Unit::className(), ['id' => 'type']);
    }

    public function getTypeTitle(){
        if($this->typeId){
            return $this->typeId->title;
        } else {
            return "";
        }
    }

    public function getSubValues(){
        return $this->hasMany(Value::className(), ['indicator_id' => 'indicator_id','sub_question_id' => 'id']);
    }
}
