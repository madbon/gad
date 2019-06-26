<?php

namespace common\modules\rms\models;

use Yii;

/**
 * This is the model class for table "lgup_attachments".
 *
 * @property int $id
 * @property string $value
 * @property string $filename
 */
class DynamicViewAttachments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bpls_attachments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'filename'], 'required'],
            [['filename'], 'string'],
            [['value'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'filename' => 'Filename',
        ];
    }
}
