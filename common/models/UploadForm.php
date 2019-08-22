<?php
namespace common\models;


use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx, xlsm, xls'],
        ];
    }
    
    public function upload()
    {
        $miliseconds = round(microtime(true) * 1000);
        $hash =  md5(date('Y-m-d')."-".date("h-i-sa")."-".$miliseconds);
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/'.$hash."-".$this->imageFile->baseName.'.'.$this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'imageFile' => 'Excel File',
        ];
    }
}
?>