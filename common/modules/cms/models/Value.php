<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_values".
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

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gad_cms_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['term_record_id', 'yearly_record_id', 'da_brgy_id','category_id', 'indicator_id', 'frequency_details_id'], 'required'],
            [['yearly_record_id', 'da_brgy_id', 'category_id', 'indicator_id', 'frequency_details_id'], 'integer'],
            [['remarks'], 'string'],
            [['term_record_id'], 'string', 'max' => 255],
            [['value'], 'string', 'max' => 200],
        ];
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
            'value' => 'This ',
            'remarks' => 'Remarks',
        ];
    }
}
