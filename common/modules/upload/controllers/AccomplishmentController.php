<?php

namespace common\modules\upload\controllers;

use Yii;
use common\models\GadAccomplishmentReport;
use yii\web\UploadedFile;
use common\models\UploadForm;
use common\modules\report\controllers\DefaultController;

class AccomplishmentController extends \yii\web\Controller
{
    public function actionIndex($ruc,$onstep,$tocreate)
    {
        $model = new UploadForm();
        $session['excelDataAccomplishment'] = null;
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
                            	$excelData[$cell->getRow()][] = $cell->getValue();
                        		$excelDataForUploading[$cell->getRow()][] = $cell->getValue();
                        }
                    } 
                }


                $session['excelDataAccomplishment'] = $excelDataForUploading;
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
                unlink('uploads/'. $session['excelFile']);
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

        $arr = $session['excelDataAccomplishment'];
        // echo "<pre>";
        // print_r($arr); exit;
       	date_default_timezone_set("Asia/Manila");
        foreach ($arr as $key => $val) {
            $model = new GadAccomplishmentReport();
            $model->record_id = DefaultController::getRecordIdByRuc($ruc);
            $model->record_tuc = $ruc;
            $model->date_created = date("Y-m-d");
            $model->time_created = date("h:i:sa");

            $model->focused_id = $val[0];
            $model->inner_category_id = $val[1];
            $model->ppa_value = $val[2];
            $model->gi_sup_data = $val[3];
            $model->source = $val[4];
            $model->cliorg_ppa_attributed_program_id = (string)$val[5];
            $model->objective = $val[6];
            $model->relevant_lgu_ppa = $val[7];
            $model->activity_category_id = $val[8];
            $model->activity = $val[9];
            $model->performance_indicator = $val[10];
            $model->actual_results = $val[11];
            $model->total_approved_gad_budget = $val[12];
            $model->actual_cost_expenditure = $val[13];
            $model->variance_remarks = $val[14];
            

            if($model->save()){

            }
            else{
            	foreach ($model->errors as $key => $value) {
            		\Yii::$app->getSession()->setFlash('danger', 'Failed to upload, '.$value[0]);
            	}
                return $this->redirect(['index', 'ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate]);
            }
        }
        $session['excelDataAccomplishment'] = null;
        // unlink('uploads/'. $session['excelFile']);
        $session['excelFile'] = null;
        \Yii::$app->getSession()->setFlash('success', 'Excel data successfully uploaded.');
        return $this->redirect(['/report/gad-accomplishment-report/index', 'ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate]);
    }

    public function actionDownloadTemplate()
    {
        $path = Yii::getAlias('@webroot').'/uploads/template/excel/Accomplishment-Report-Template.xlsx';
        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path);
        }
        else{
            \Yii::$app->getSession()->setFlash('danger', '<strong>Unable to download the template of Service Record (excel)</strong>');
            return $this->redirect(['upload-service-record']);
        }
    }

}