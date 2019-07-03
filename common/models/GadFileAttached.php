<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_file_attached".
 *
 * @property int $id
 * @property string $file_name
 * @property int $model_id
 * @property string $model_name
 * @property string $hash
 * @property string $extension
 * @property int $file_folder_type_id
 */
class GadFileAttached extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'gad_file_attached';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_folder_type_id','model_name'], 'required'],
            [['model_id', 'file_folder_type_id'], 'integer'],
            // [['file_name'], 'string', 'max' => 250],
            [['model_name', 'hash'], 'string', 'max' => 150],
            [['extension'], 'string', 'max' => 10],
            [['file_name'], 'file', 'extensions' => ['jpg','jpeg','png'],'maxFiles'=>0,'skipOnEmpty'=>false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'model_id' => 'Model ID',
            'model_name' => 'Model Name',
            'hash' => 'Hash',
            'extension' => 'Extension',
            'file_folder_type_id' => 'Attachement(s) Category',
        ];
    }
}
