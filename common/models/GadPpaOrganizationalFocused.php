<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_ppa_organizational_focused".
 *
 * @property int $id
 * @property string $title
 */
class GadPpaOrganizationalFocused extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_ppa_organizational_focused';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
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
            'title' => 'Title',
        ];
    }
}
