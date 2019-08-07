<?php

namespace common\modules\upload\controllers;

use Yii;
use common\models\GadPlanBudget;
use yii\web\UploadedFile;
use common\models\UploadForm;
use common\modules\report\controllers\DefaultController;

class PlanController extends \yii\web\Controller
{
    public function actionIndex($ruc,$onstep,$tocreate)
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
            $miliseconds = round(microtime(true) * 1000);
        	$hash =  md5(date('Y-m-d')."-".date("h-i-sa")."-".$miliseconds);
            if ($model->upload()) {
                $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(TRUE);
                
                $spreadsheet    = $reader->load("uploads/".$hash."-".$model->imageFile->baseName.'.'.$model->imageFile->extension);
                $worksheet      = $spreadsheet->getActiveSheet();
                foreach ($worksheet->getRowIterator() as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(FALSE);
                    foreach ($cellIterator as $key => $cell) {
                        if($cell->getRow() >= 3){
                            // if(!empty($cell->getValue()))
                            // {
                            	if($cell->getColumn() == 'L' || $cell->getColumn() == 'M'){
	                                $excelData[$cell->getRow()][] = \PhpOffice\PhpSpreadsheet\Style\NumberFormat::toFormattedString($cell->getValue(), 'YYYY-MM-DD');
	                                $excelDataForUploading[$cell->getRow()][] = \PhpOffice\PhpSpreadsheet\Style\NumberFormat::toFormattedString($cell->getValue(), 'YYYY-MM-DD');
	                            }
	                            else{
	                            	$excelData[$cell->getRow()][] = $cell->getValue();
                            		$excelDataForUploading[$cell->getRow()][] = $cell->getValue();
	                            }
                        }
                    } 
                }


                $session['excelDataPlan'] = $excelDataForUploading;
                $userinfo = Yii::$app->user->identity->id;
                $fileName = $model->imageFile->baseName;

                $ext = $model->imageFile->extension;
                $session['excelFile'] = $hash."-".$fileName.'.'.$ext;
                $excelFilename = $hash."-".$fileName.'.'.$ext;
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
            'ruc' => $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate
        ]);
    }

    public function actionSaveExcelData($ruc,$onstep,$tocreate)
    {
        $session = Yii::$app->session;

        $arr = $session['excelDataPlan'];
        
       	date_default_timezone_set("Asia/Manila");
        foreach ($arr as $key => $val) {
            $model = new GadPlanBudget();
            $model->record_id = DefaultController::getRecordIdByRuc($ruc);
            $model->record_tuc = $ruc;
            $model->date_created = date("Y-m-d");
            $model->time_created = date("h:i:sa");

            $model->focused_id = $val[0];
            $model->inner_category_id = $val[1];
            $model->gi_sup_data = $val[3];
            $model->source = $val[4];
            $model->ppa_value = $val[2];
            $model->cliorg_ppa_attributed_program_id = $val[5];
            $model->objective = $val[6];
            $model->relevant_lgu_program_project = $val[7];
            $model->activity_category_id = $val[8];
            $model->activity = $val[9];
            $model->performance_target = $val[10];
            $model->date_implement_start = $val[11];
            $model->date_implement_end = $val[12];
            $model->budget_mooe = $val[13];
            $model->budget_ps = $val[14];
            $model->budget_co = $val[15];
            $model->lead_responsible_office = $val[16];

            if($model->save(false)){

            }
            else{
            	// print_r($model->errors); exit;
                \Yii::$app->getSession()->setFlash('danger', 'Failed to upload. Check your excel it may have an invalid format of data or cell value. Kindly read the instructions carefully.');
                return $this->redirect('@web/pds/upload/training');
            }
        }
        $session['excelDataPlan'] = null;
        unlink('uploads/'. $session['excelFile']);
        $session['excelFile'] = null;
        \Yii::$app->getSession()->setFlash('success', 'Excel data successfully uploaded.');
        return $this->redirect(['/report/gad-plan-budget/index', 'ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate]);
    }

    public function actionDownloadTemplate()
    {
        $path = Yii::getAlias('@webroot').'/uploads/template/excel/GAD-Plan-Budget-Template.xlsx';
        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path);
        }
        else{
            \Yii::$app->getSession()->setFlash('danger', '<strong>Unable to download the template of Service Record (excel)</strong>');
            return $this->redirect(['upload-service-record']);
        }
    }

}