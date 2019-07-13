<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_category".
 *
 * @property integer $id
 * @property string $title
 * @property string $frequency
 *
 * @property cmsIndicators[] $cmsIndicators
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gad_cms_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string'],
            [['frequency_id','applicable_to','left_or_right'], 'integer'],
            [['sort'], 'number'],
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
            'frequency_id' => 'Frequency',
            'lgup_content_type_id' => 'Content Type',
            'lgup_content_width_id' => 'Content Width',
            'applicable_to' => 'Form Type',
            'frequencyRelation.title' => 'Frequency',
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
        return $this->hasMany(Indicator::className(), ['category_id' => 'id'])->andOnCondition(['not in', 'id', ['171', '172', '173']]);
    }

    public function getAllParent()
    {
        return $this->hasMany(Indicator::className(), ['category_id' => 'id'])->andOnCondition(['not in', 'id', ['171', '172', '173']])->andOnCondition(['parent' => 0]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllQuestions()
    {
        return $this->hasMany(Indicator::className(), ['category_id' => 'id'])->andOnCondition(['not in', 'id', ['171', '172', '173']])->andOnCondition(['not in','type_id', ['1','3']]);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
/*    public function getWithDrugPresenceIndicators()
    {
        return $this->hasMany(Indicator::className(), ['category_id' => 'id'])->andOnCondition(['in','type_id', ['1','3']])->andOnCondition(['parent' => 157]);
    }
*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Value::className(), ['category_id' => 'id']);
    }

    public function getCheckValues($termid){
        $qry = Value::find()->where(['category_id' => $this->id, 'term_record_id' => $termid, 'yearly_record_id' => NULL])->all();
        $cnt = count($qry);
        return $cnt;
    }

    public function getCheckValues2($termid, $year){
        $yrrec = BarangayRecord::find()->where(['term_record_id' => $termid, 'year_id' => $year])->One();
        if ($yrrec){
            $qry = Value::find()->where(['category_id' => $this->id, 'term_record_id' => $termid, 'yearly_record_id' => $yrrec->id])->all();
            $cnt = count($qry);
        } else {
            $cnt = 0;
        }
        return $cnt;
    }

    public function getCheckValues3($termid, $year, $freq){
        $yrrec = BarangayRecord::find()->where(['term_record_id' => $termid, 'year_id' => $year])->One();
        if ($yrrec){
            $qry = Value::find()->where(['category_id' => $this->id, 'term_record_id' => $termid, 'yearly_record_id' => $yrrec->id, 'frequency_details_id' => $freq])->all();
            $cnt = count($qry);
        } else {
            $cnt = 0;
        }
        return $cnt;
    }

    public function getFrequencyRelation()
    {
        return $this->hasOne(Frequency::className(), ['id' => 'frequency_id']);
    }


}
