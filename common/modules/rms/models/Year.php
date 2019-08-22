<?php

namespace common\modules\rms\models;

use Yii;

/**
 * This is the model class for table "bis_year".
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

}
