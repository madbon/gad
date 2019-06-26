<?php

namespace common\modules\rms\models;

use Yii;
/**
 * This is the model class for object "range".
 */
class YearOfRange extends \yii\base\Model
{
    public $year;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'year' => 'Year',
        ];
    }

}
