<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_plan_type".
 *
 * @property int $id
 * @property string $title
 */
class GadPlanType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_plan_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','code'],'required'],
            [['title','description'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }
}
