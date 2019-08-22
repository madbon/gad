<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_year".
 *
 * @property integer $id
 * @property string $title
 * @property string $def
 */
class Year extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bpls_year';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 4],
            [['def'], 'string', 'max' => 10],
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
            'def' => 'Def',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerm()
    {
        return $this->hasOne(Term::className(), ['id' => 'term_id']);
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangayRecord($t)
    {
        return BarangayRecord::find()->where(['term_record_id' => $t, 'year_id' => $this->id])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiscalInfo()
    {
        return FiscalInfo::find()->where(['year_id' => $this->id])->One();
    }


/*    public function getCheckRecord($t){
        $x = 0;
        if($this->getBarangayRecord($t)){
            if($this->barangayRecord->award){ $x++; }
            if($this->barangayRecord->demographicInfo) {$x++;}
            if($this->barangayRecord->serviceInfo) {$x++;}
            if($this->barangayRecord->fiscalInfo) {$x++;}
            if($this->barangayRecord->barangayWorkerNo) {$x++;}  
        }
        return $x;
    }*/
}
