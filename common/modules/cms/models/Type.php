<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_type".
 *
 * @property integer $id
 * @property string $title
 *
 * @property cmsIndicators[] $cmsIndicators
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gad_cms_type';
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getcmsIndicators()
    {
        return $this->hasMany(cmsIndicators::className(), ['type_id' => 'id']);
    }
}
