<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_status_assignment".
 *
 * @property int $id
 * @property string $role
 * @property string $status
 */
class GadStatusAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_status_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role'], 'required'],
            [['description','rbac_role','status_code'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Permission',
            'status' => 'Status',
            'rbac_role' => 'RBAC Role',
            'status_code' => 'Current Report Status',
        ];
    }
}
