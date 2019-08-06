<?php

namespace common\modules\upload\controllers;

use Yii;
use common\models\GadPlanBudget;
use yii\web\UploadedFile;
use common\models\UploadForm;

class PlanController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new UploadForm();
        $excelFilename = null;
        $worksheet = null;
        $excelData = [];
        $excelDataForUploading = [];

        if (Yii::$app->request->isPost) {
            $session            = Yii::$app->session;
            $model->imageFile   = UploadedFile::getInstance($model, 'imageFile');
            $data               = Yii::$app->request->post();

            if ($model->upload()) {
                $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(TRUE);
                $spreadsheet    = $reader->load("uploads/".$model->imageFile->baseName.'.'.$model->imageFile->extension);
                $worksheet      = $spreadsheet->getActiveSheet();
                foreach ($worksheet->getRowIterator() as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(FALSE);
                    foreach ($cellIterator as $key => $cell) {
                        if($cell->getRow() >= 2){
                            if($cell->getColumn() == 'B' || $cell->getColumn() == 'C'){
                                $excelData[$cell->getRow()][] = \PhpOffice\PhpSpreadsheet\Style\NumberFormat::toFormattedString($cell->getValue(), 'YYYY-MM-DD');
                                $excelDataForUploading[$cell->getRow()][] = \PhpOffice\PhpSpreadsheet\Style\NumberFormat::toFormattedString($cell->getValue(), 'YYYY-MM-DD');
                            }
                            else {
                                $excelData[$cell->getRow()][] = $cell->getValue();
                                $excelDataForUploading[$cell->getRow()][] = $cell->getValue();
                            }
                        }
                    }
                }

                $session['excelData'] = $excelDataForUploading;
                $userinfo = Yii::$app->user->identity->id;
                $fileName = Yii::$app->user->identity->id.'-'.date('mdY').'-'.$model->imageFile->baseName;
                $ext = $model->imageFile->extension;

                $session['excelFile'] = $fileName.'.'.$ext;
                $excelFilename = $fileName.'.'.$ext;
                Yii::$app->db->createCommand()->insert('gad_excel_attachments',
                    [
                        'user_id' => $userinfo,
                        'filename' => $fileName,
                        'type' => $ext,
                    ])
                ->execute();
            }
        }

        return $this->render('index',[
            'model' => $model,
            'excelData' => $excelData,
            'excelFilename' => $excelFilename,
        ]);
    }

}
