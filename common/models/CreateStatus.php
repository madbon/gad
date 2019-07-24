<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_create_status".
 *
 * @property int $id
 * @property int $code
 * @property string $title
 * @property int $is_active
 */
class CreateStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_create_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code', 'is_active'], 'integer'],
            [['title'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'title' => 'Title',
            'is_active' => 'Is Active',
        ];
    }
}
