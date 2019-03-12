<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_ppa_attributed_program".
 *
 * @property int $id
 * @property string $title
 */
class GadPpaAttributedProgram extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_ppa_attributed_program';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
