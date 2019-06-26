<?php

namespace common\modules\rms\models;

use Yii;

/**
 * This is the model class for table "bis_unit".
 *
 * @property integer $id
 * @property string $title
 *
 * @property BisIndicators[] $bisIndicators
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bpls_unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 50],
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
        ];
    }

}
