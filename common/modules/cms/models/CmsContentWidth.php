<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "lgup_content_width".
 *
 * @property int $id
 * @property string $class_name
 * @property string $description
 */
class CmsContentWidth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bpls_content_width';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_name', 'description'], 'required'],
            [['class_name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_name' => 'Class Name',
            'description' => 'Description',
        ];
    }
}
