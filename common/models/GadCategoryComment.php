<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_category_comment".
 *
 * @property int $id
 * @property int $category_id
 * @property int $record_id
 * @property string $value
 */
class GadCategoryComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_category_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'record_id'], 'integer'],
            [['value'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'record_id' => 'Record ID',
            'value' => 'Value',
        ];
    }
}
