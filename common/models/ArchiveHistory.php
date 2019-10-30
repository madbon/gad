<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gad_archive_history".
 *
 * @property int $id
 * @property int $record_id
 * @property string $record_tuc
 * @property int $archiveby_userid
 * @property string $archiveby_name
 * @property string $remarks
 * @property int $status
 * @property string $date_created
 * @property string $date_restored
 */
class ArchiveHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gad_archive_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['record_id', 'archiveby_userid', 'status'], 'required'],
            [['record_id', 'archiveby_userid', 'status'], 'integer'],
            [['date_created', 'date_restored'], 'safe'],
            [['record_tuc', 'remarks'], 'string', 'max' => 250],
            [['archiveby_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'record_id' => 'Record ID',
            'record_tuc' => 'Record Tuc',
            'archiveby_userid' => 'Archiveby Userid',
            'archiveby_name' => 'Archiveby Name',
            'remarks' => 'Remarks',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'date_restored' => 'Date Restored',
        ];
    }
}
