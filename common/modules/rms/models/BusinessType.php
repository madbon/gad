<?php

namespace common\modules\rms\models;

use Yii;

/**
 * This is the model class for table "bpls_business_type".
 *
 * @property int $id
 * @property string $description
 *
 * @property BplsUploadedClient[] $bplsUploadedClients
 */
class BusinessType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bpls_business_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBplsUploadedClients()
    {
        return $this->hasMany(BplsUploadedClient::className(), ['business_type' => 'id']);
    }
}
