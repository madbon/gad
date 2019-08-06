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
                        if($cell->getRow() >= 3){
                            // if($cell->getColumn() == 'B' || $cell->getColumn() == 'C'){
                            //     $excelData[$cell->getRow()][] = \PhpOffice\PhpSpreadsheet\Style\NumberFormat::toFormattedString($cell->getValue(), 'YYYY-MM-DD');
                            //     $excelDataForUploading[$cell->getRow()][] = \PhpOffice\PhpSpreadsheet\Style\NumberFormat::toFormattedString($cell->getValue(), 'YYYY-MM-DD');
                            // }
                            // else {
                                
                            // }
                            $excelData[$cell->getRow()][] = $cell->getValue();
                            $excelDataForUploading[$cell->getRow()][] = $cell->getValue();
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

     public function actionSaveExcelData($hc)
    {
        $session = Yii::$app->session;
        $arr = array_values($session['excelData']);

        foreach ($arr as $key => $value) {
        	// echo "<pre>";
        	// print_r($value);
            $model = new Training();
            $model->hris_i_personal_info_id =  $hc;
            $model->training_desc 			=  $value[0];
            $model->inclusivedate_from 		=  $value[1];
            $model->inclusivedate_to 		=  $value[2];
            $model->numberofhours 			=  $value[3];
            $model->condsponby 				=  $value[5];
            
            switch ($value[4]) {
            	case 1:
            		$model->hris_training_type_id = 1;
            	break;
            	case 2:
            		$model->hris_training_type_id = 2;
            	break;
            	case 3:
            		$model->hris_training_type_id = 3;
            	break;
            	
            	default:
            		$model->hris_training_type_id = 0;
            		$model->typeoflearningdevelopment = $value[4];
            	break;
            }

            
            if($model->save()){

            }
            else{
            	// print_r($model->errors); exit;
                \Yii::$app->getSession()->setFlash('danger', 'Failed to upload. Check your excel it may have an invalid format of data or cell value. Kindly read the instructions carefully.');
                return $this->redirect('@web/pds/upload/training');
            }
        }
        $session['excelData'] = null;
        unlink('uploads/'. $session['excelFile']);
        $session['excelFile'] = null;
        \Yii::$app->getSession()->setFlash('success', 'Excel data successfully uploaded.');
        return $this->redirect('@web/pds/upload/training');
    }

}
