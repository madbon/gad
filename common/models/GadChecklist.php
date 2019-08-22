<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_checklist".
 *
 * @property int $id
 * @property int $report_type_id
 * @property string $title
 * @property int $is_hidden
 */
class GadChecklist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_checklist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_type_id', 'is_hidden','title','sort'], 'required'],
            [['report_type_id', 'is_hidden'], 'integer'],
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
            'report_type_id' => 'Report Type',
            'title' => 'Title',
            'is_hidden' => 'Visible?',
        ];
    }
}
