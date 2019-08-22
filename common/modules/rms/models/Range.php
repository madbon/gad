<?php

namespace common\modules\rms\models;

use Yii;
/**
 * This is the model class for object "range".
 */
class Range extends \yii\base\Model
{
    public $from;
    public $to;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from', 'to'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'from' => 'From',
            'to' => 'To',
        ];
    }

}
