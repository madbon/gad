<?php

namespace common\modules\cms\models;

use Yii;

/**
 * This is the model class for table "cms_ind_default_choices".
 *
 * @property integer $id
 * @property string $title
 */
class DefaultChoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bpls_ind_default_choices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 100],
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
    public function getChoices()
    {
        return Choice::find()->where(['default_choice_id' => $this->id])->all();
    }
}
