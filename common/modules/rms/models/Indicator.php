<?php

namespace common\modules\rms\models;

use Yii;

/**
 * This is the model class for table "bis_indicators".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property integer $type_id
 * @property integer $frequency_id
 * @property integer $unit_id
 *
 * @property BisCategory $category
 * @property BisType $type
 * @property BisFrequency $frequency
 * @property BisUnit $unit
 */
class Indicator extends \yii\db\ActiveRecord
{
    public $with_question;
    public $answer_with_question;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bpls_indicator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'type_id', 'is_required'], 'required'],
            [['category_id', 'type_id', 'frequency_id', 'unit_id', 'default_choice_id', 'parent'], 'integer'],
            [['title', 'with_question', 'answer_with_question'], 'string'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['frequency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Frequency::className(), 'targetAttribute' => ['frequency_id' => 'id']],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit_id' => 'id']],

            [['default_choice_id'], 'required', 'when' => function($model){
                return $model->unit_id == '7';
            }, 'whenClient' => 'function(attribute, value){
                return $("#indicator-unit_id").val() == "7";
            }'],

            [['frequency_id', 'unit_id'], 'required', 'when' => function($model){
                return $model->type_id == '2';
            }, 'whenClient' => 'function(attribute, value){
                return $("#indicator-type_id").val() == "2";
            }'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category',
            'title' => 'Title',
            'type_id' => 'Type',
            'frequency_id' => 'Frequency',
            'unit_id' => 'Unit',
            'categoryTitle' => 'Category',
            'typeTitle' => 'Type',
            'frequencyTitle' => 'Frequency',
            'unitTitle' => 'Unit',
            'default_choice_id' => 'Choice',
            'with_question' => 'Sub Question',
            'choicesList' => 'Choices',
            'parent' => 'Parent'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getCategoryTitle(){
        return $this->category ? $this->category->title : "" ;
    }   
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }

    public function getTypeTitle(){
        return $this->type ? $this->type->title : "" ;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrequency()
    {
        return $this->hasOne(Frequency::className(), ['id' => 'frequency_id']);
    }

    public function getFrequencyTitle(){
        return $this->frequency ? $this->frequency->title : "" ;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultChoice()
    {
        return $this->hasOne(DefaultChoice::className(), ['id' => 'default_choice_id']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManyChoices()
    {
        return $this->hasMany(Choice::className(), ['indicator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChoices()
    {
        if($this->default_choice_id != 1){
            return Choice::find()->where(['default_choice_id' => $this->default_choice_id])->all();
        } else {
            return Choice::find()->where(['indicator_id' => $this->id])->all();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }

    public function getUnitTitle(){
        return $this->unit ? $this->unit->title : "" ;
    }

    public function getCheckSubQuestion(){
        return ChoiceWithSubQuestion::find()->where(['indicator_id' => $this->id])->exists(); 
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubQuestions()
    {
        return $this->hasMany(SubQuestion::className(), ['indicator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSelectedChoice()
    {
        return $this->hasOne(ChoiceWithSubQuestion::className(), ['indicator_id' => 'id']);
    }

    public function getChoicesList(){
        if($this->choices){
            $a = "<ul>";
            foreach($this->choices as $choice) {
                $a .= "<li>".$choice->value."</li>";
            }
            $a .= "</ul>";
            return $a;
        } else {
            return "";
        }
    }

    public function getAnswer()
    {
        $qry = ChoiceWithSubQuestion::find()->where(['indicator_id' => $this->id])->One();
        if($qry){
            return $qry->answer;
        } else {
            return "";
        }
    }

    public function getIndicatorTitle(){
        return $this->title ? substr($this->title, 0, 130): "" ;
    }

    public function getChild(){
        return $this->hasMany(Indicator::className(), ['parent' => 'id']);
    }

    public function getChilds(){
        return $this->hasMany(Indicator::className(), ['parent' => 'id'])->andOnCondition(['in','type_id', ['2']]);
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWithDrugPresenceIndicators()
    {
        return $this->hasMany(Indicator::className(), ['parent' => 'id'])->andOnCondition(['in','type_id', ['2']])->andOnCondition(['parent' => 16]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWithAntiDrugActivities()
    {
        return $this->hasMany(Indicator::className(), ['parent' => 'id'])->andOnCondition(['in','type_id', ['2']])->andOnCondition(['parent' => 26]);
    }

}