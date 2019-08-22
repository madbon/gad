<?php

namespace common\modules\rms\models;

use Yii;
use common\modules\cms\models\CmsContentType;
use common\modules\cms\models\CmsContentWidth;

/**
 * This is the model class for table "bis_category".
 *
 * @property integer $id
 * @property string $title
 * @property string $frequency
 *
 * @property BisIndicators[] $bisIndicators
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bpls_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string'],
            [['frequency_id'], 'integer'],
            [['lgup_content_type_id'], 'integer'],
            [['lgup_content_width_id'], 'integer'],
            [['frequency'], 'string', 'max' => 30],
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
            'frequency' => 'Frequency',
            'frequency_id' => 'Frequency ID',
            'lgup_content_type_id' => 'Content Type',
            'lgup_content_width_id' => 'Content Width',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicators()
    {
        return $this->hasMany(Indicator::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllIndicators()
    {
        return $this->hasMany(Indicator::className(), ['category_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

    public function getAllParent()
    {
        return $this->hasMany(Indicator::className(), ['category_id' => 'id'])/*->andOnCondition(['not in', 'id', ['30', '31', '32']])*/->andOnCondition(['parent' => 0]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllQuestions()
    {
        return $this->hasMany(Indicator::className(), ['category_id' => 'id'])/*->andOnCondition(['not in', 'id', ['30', '31', '32']])*/->andOnCondition(['not in','type_id', ['1','3']]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Value::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsContentType()
    {
        return $this->hasOne(CmsContentType::className(), ['id' => 'lgup_content_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsContentWidth()
    {
        return $this->hasOne(CmsContentWidth::className(), ['id' => 'lgup_content_width_id']);
    }

}
