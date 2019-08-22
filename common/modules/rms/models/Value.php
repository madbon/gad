<?php

namespace common\modules\rms\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "bis_values".
 *
 * @property integer $id
 * @property string $term_record_id
 * @property integer $yearly_record_id
 * @property integer $category_id
 * @property integer $indicator_id
 * @property integer $frequency_details_id
 * @property string $value
 * @property string $remarks
 */
class Value extends \yii\db\ActiveRecord
{
    public $category_title;
    public $indicator_title;
    public $part_of_chart;
    public $type_title;
    public $unit_title;
    public $unit_id;
    public $choices = [];
    public $ans;
    public $subs = [];
    public $checktype;
    public $type;
    public $sub_question;
    public $frequency_details;
    // public $has_files = false;
    public $imageFiles;
    public $is_required;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bpls_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'maxFiles' => 99],
            [['user_id'], 'safe'],
            [['term_record_id', 'yearly_record_id', 'da_brgy_id','category_id', 'indicator_id', 'frequency_details_id'], 'required'],
            [['yearly_record_id', 'da_brgy_id', 'category_id', 'indicator_id', 'frequency_details_id'], 'integer'],
            [['remarks'], 'string'],
            [['term_record_id'], 'string', 'max' => 255],
            [['value'], 'string', 'max' => 200],
        ];

        if(!empty($this->indicator->is_required) && $this->indicator->is_required == 2){
            if(empty($this->sub_question_id)){
                $rules[] = [['value'], 'required'];
            }
            else{
                $rules[] = [['value'], 'safe'];
            }
        }
        else{
            $rules[] = [['value'], 'safe'];
        }

        return $rules;

    }

    // public function checkHasFiles($attribute_name, $params)
    // {
    //         $fi = new \FilesystemIterator(Yii::$app->getModule('file')->getUserDirPath(), \FilesystemIterator::SKIP_DOTS);
    //         if(iterator_count($fi) > 0 || $this->has_files){
    //             $this->has_files = true;
    //             return true;
    //         }else{
    //             $this->addError($attribute_name, 'Please attach files');
    //             return false;
    //         }    
    // }

    // public function behaviors()
    // {
    //     return [
    //         'fileBehavior' => [
    //             'class' => \file\behaviors\FileBehavior::className()
    //         ]
    //     ];
    // }    

    // public function afterFind(){
    //     parent::afterFind();
    //     if($this->files){
    //         $this->has_files = true;
    //     }
    // }

    public function getIndicator()
        {
            return $this->hasOne(Indicator::className(), ['id' => 'indicator_id']);
        }

    public function upload()
    {
        if ($this->validate()) { 
            foreach ($this->imageFiles as $file) {
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }

    public function getUserRecord()
    {
        return $this->hasOne(Record::className(), ['id' => 'da_brgy_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'term_record_id' => 'Term Record ID',
            'yearly_record_id' => 'Yearly Record ID',
            'category_id' => 'Category ID',
            'indicator_id' => 'Indicator ID',
            'frequency_details_id' => 'Frequency Details ID',
            'value' => 'This field ',
            'remarks' => 'Remarks',
        ];
    }
}
