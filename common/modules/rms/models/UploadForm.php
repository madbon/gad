<?php

namespace common\modules\rms\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx, csv, xls'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'imageFile' => 'File Attachment:',            
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/'.Yii::$app->user->identity->id.'-'.date('mdY').'-'.$this->imageFile->baseName.'.'.$this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}