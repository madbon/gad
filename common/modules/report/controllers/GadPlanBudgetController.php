<?php

namespace common\modules\report\controllers;

use Yii;
use common\models\GadPpaAttributedProgram;
use common\models\GadFocused;
use common\models\GadInnerCategory;
use common\models\GadPlanBudget;
use common\models\GadPlanBudgetSearch;
use common\models\GadRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use niksko12\user\models\UserInfo;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\GadFileAttached;



/**
 * GadPlanBudgetController implements the CRUD actions for GadPlanBudget model.
 */
class GadPlanBudgetController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreateComment()
    {
        
    }

    public function ComputeGadBudget($ruc)
    {
        $dataAttributedProgram = (new \yii\db\Query())
        ->select([
            'AP.id',
            // 'IF(AP.ppa_attributed_program_id = 0, AP.ppa_attributed_program_others, PAP.title) as ap_ppa_value',
            'AP.lgu_program_project',
            'AP.hgdg',
            'AP.total_annual_pro_budget',
            'AP.attributed_pro_budget',
            'AP.ap_lead_responsible_office',
            'AP.record_tuc',
            'AP.controller_id'
        ])
        ->from('gad_attributed_program AP')
        ->leftJoin(['PAP' => 'gad_ppa_attributed_program'], 'PAP.id = AP.ppa_attributed_program_id')
        ->where(['AP.record_tuc' => $ruc])
        ->groupBy(['AP.lgu_program_project'])
        ->orderBy(['AP.id' => SORT_ASC,'AP.lgu_program_project' => SORT_ASC])
        ->all();

        $varTotalGadAttributedProBudget = 0;
        foreach ($dataAttributedProgram as $key => $dap) {
            $varHgdg = $dap["hgdg"];
            $varTotalAnnualProBudget = $dap["total_annual_pro_budget"];
            $computeGadAttributedProBudget = 0;
            $HgdgMessage = null;
            $HgdgWrongSign = "";
            
            if($varHgdg < 4) // 0%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if($varHgdg >= 4 && $varHgdg <= 7.99) // 25%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.25);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if($varHgdg >= 8 && $varHgdg <= 14.99) // 50%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.50);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if($varHgdg <= 19.99 && $varHgdg >= 15) // 75%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.75);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if($varHgdg == 20) // 100%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 1);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else
            {
                
            }
        }

        $dataPlanBudget = (new \yii\db\Query())
        ->select([
            'PB.id',
            'PB.ppa_value',
            // 'IF(PB.ppa_focused_id = 0, PB.cause_gender_issue,CF.title) as activity_category',
            'PB.cause_gender_issue as other_activity_category',
            'PB.objective',
            'PB.relevant_lgu_program_project',
            'PB.activity',
            'PB.performance_target',
            'PB.performance_indicator',
            'PB.budget_mooe',
            'PB.budget_ps',
            'PB.budget_co',
            'PB.lead_responsible_office',
            'COUNT(GC.plan_budget_id) as count_comment',
            'GC.attribute_name as attr_name',
            'PB.record_tuc as record_uc',
            'GF.title as gad_focused_title',
            'IC.title as inner_category_title',
            'GC.id as gad_focused_id',
            'IC.id as inner_category_id',
            'PB.focused_id'
        ])
        ->from('gad_plan_budget PB')
        // ->leftJoin(['CF' => 'gad_ppa_client_focused'], 'CF.id = PB.ppa_focused_id')
        ->leftJoin(['GC' => 'gad_comment'], 'GC.plan_budget_id = PB.id')
        ->leftJoin(['GF' => 'gad_focused'], 'GF.id = PB.focused_id')
        ->leftJoin(['IC' => 'gad_inner_category'], 'IC.id = PB.inner_category_id')
        ->where(['PB.record_tuc' => $ruc])
        ->orderBy(['PB.focused_id' => SORT_ASC,'PB.inner_category_id' => SORT_ASC,'PB.ppa_value' => SORT_ASC,'PB.id' => SORT_ASC])
        ->groupBy(['PB.focused_id','PB.inner_category_id','PB.ppa_value','PB.objective','PB.relevant_lgu_program_project','PB.activity','PB.performance_target'])
        ->all();
        // echo "<pre>";
        // print_r($dataPlanBudget); exit;

        $sum_dbp_mooe = 0;
        $sum_dbp_ps = 0;
        $sum_dbp_co = 0;
        $sum_db_budget = 0;
        foreach ($dataPlanBudget as $key => $dpb) {
            $sum_dbp_mooe += $dpb["budget_mooe"];
            $sum_dbp_ps += $dpb["budget_ps"];
            $sum_dbp_co += $dpb["budget_co"];
        }
        $sum_db_budget = ($sum_dbp_co + $sum_dbp_mooe + $sum_dbp_ps);
        $grand_total_pb = ($sum_db_budget + $varTotalGadAttributedProBudget);

        $qryRecord = GadRecord::find()->where(['tuc' => $ruc])->one();
        $recTotalLguBudget = $qryRecord->total_lgu_budget;

        $fivePercentTotalLguBudget = ($recTotalLguBudget * 0.05);

        if($grand_total_pb < $fivePercentTotalLguBudget)
        {
            return "<span style='color:red;'>  Php ".number_format($grand_total_pb,2)."</span>";
        }
        else
        {
            return "<span style='color:blue;'>  Php ".number_format($grand_total_pb,2)."</span>";
        }
    }

    public function actionChangeReportStatus($status,$tuc,$onstep,$tocreate)
    {
        $qry = GadRecord::find()->where(['tuc' => $tuc])->one();

        if($status == 1)
        {
            if(!empty($qry->attached_ar_record_id))
            {
                $queryAr = GadRecord::updateAll(['footer_date' => date("Y-m-d"), 'status' => $status], 'id = '.$qry->attached_ar_record_id.' ');
            }
            $qry->status = $status;
        }
        else if($status == 2 || $status == 3)
        {
            // if gpb is submit to dilg field office
            $qry->footer_date = date("Y-m-d");
            $qry->status = $status;
        }
        else
        {
            $qry->status = $status;
        }

        $qry->save(false);

        if($onstep == "to_create_ar")
        {
            $redirectTo = "gad-accomplishment-report/index";
        }
        else
        {
            $redirectTo = "gad-plan-budget/index";
        }

        \Yii::$app->getSession()->setFlash('success', "Action has been performed");
        return $this->redirect([$redirectTo, 'ruc' => $tuc,'onstep' => $onstep, 'tocreate' => $tocreate]);
    }

    /**
     * Lists all GadPlanBudget models.
     * @return mixed
     */
    public function actionIndex($ruc,$onstep,$tocreate)
    {
        $model = new GadPlanBudget();
        Yii::$app->session["activelink"] = $tocreate;
        $grand_total_pb = 0;
        $dataRecord = GadRecord::find()->where(['tuc' => $ruc, 'report_type_id' => 1])->all();
        $dataAttributedProgram = (new \yii\db\Query())
        ->select([
            'AP.id',
            // 'IF(AP.ppa_attributed_program_id = 0, AP.ppa_attributed_program_others, PAP.title) as ap_ppa_value',
            'AP.lgu_program_project',
            'AP.hgdg',
            'AP.total_annual_pro_budget',
            'AP.attributed_pro_budget',
            'AP.ap_lead_responsible_office',
            'AP.record_tuc',
            'AP.controller_id',
            'REC.status as record_status'
        ])
        ->from('gad_attributed_program AP')
        ->leftJoin(['PAP' => 'gad_ppa_attributed_program'], 'PAP.id = AP.ppa_attributed_program_id')
        ->leftJoin(['REC' => 'gad_record'], 'REC.tuc = AP.record_tuc')
        ->where(['AP.record_tuc' => $ruc])
        ->groupBy(['AP.lgu_program_project'])
        ->orderBy(['AP.id' => SORT_ASC,'AP.lgu_program_project' => SORT_ASC])
        ->all();

        $sum_ap_apb = 0;
        $varTotalGadAttributedProBudget = 0;
        foreach ($dataAttributedProgram as $key => $dap) {
            $varHgdg = $dap["hgdg"];
            $varTotalAnnualProBudget = $dap["total_annual_pro_budget"];
            $computeGadAttributedProBudget = 0;
            $HgdgMessage = null;
            $HgdgWrongSign = "";
            
            if($varHgdg < 4) // 0%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if($varHgdg >= 4 && $varHgdg <= 7.9) // 25%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.25);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if($varHgdg >= 8 && $varHgdg <= 14.9) // 50%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.50);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if($varHgdg >= 15 && $varHgdg <= 19.9) // 75%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.75);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if($varHgdg == 20) // 100%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 1);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else
            {
                
            }
        }
        

        $qryRecord = (new \yii\db\Query())
        ->select([
            'REG.region_m as region_name',
            'PRV.province_m as province_name',
            'CTC.citymun_m as citymun_name',
            'GR.total_lgu_budget',
            'GR.total_gad_budget',
            'GR.status as record_status'

        ])
        ->from('gad_record GR')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = GR.region_c')
        ->leftJoin(['PRV' => 'tblprovince'], 'PRV.province_c = GR.province_c')
        ->leftJoin(['CTC' => 'tblcitymun'], 'CTC.citymun_c = GR.citymun_c AND CTC.province_c = GR.province_c')
        ->where(['GR.tuc' => $ruc])
        ->groupBy(['GR.id'])->one();
        $recRegion = !empty($qryRecord['region_name']) ? $qryRecord['region_name'] : "";
        $recProvince = !empty($qryRecord['province_name']) ? $qryRecord['province_name'] : "";
        $recCitymun = !empty($qryRecord['citymun_name']) ? $qryRecord['citymun_name'] : "";
        $recTotalLguBudget = !empty($qryRecord['total_lgu_budget']) ? $qryRecord['total_lgu_budget'] : 0;
        $recTotalGadBudget = !empty($qryRecord['total_gad_budget']) ? $qryRecord['total_gad_budget'] : 0;

        $fivePercentTotalLguBudget = ($recTotalLguBudget * 0.05);


        $dataPlanBudget = (new \yii\db\Query())
        ->select([
            'PB.id',
            'PB.ppa_value',
            // 'IF(PB.ppa_focused_id = 0, PB.cause_gender_issue,CF.title) as activity_category',
            'PB.cause_gender_issue as other_activity_category',
            'PB.objective',
            'PB.relevant_lgu_program_project',
            'PB.activity',
            'PB.performance_target',
            'PB.performance_indicator',
            'PB.budget_mooe',
            'PB.budget_ps',
            'PB.budget_co',
            'PB.lead_responsible_office',
            'COUNT(GC.plan_budget_id) as count_comment',
            'GC.attribute_name as attr_name',
            'PB.record_tuc as record_uc',
            'GF.title as gad_focused_title',
            'IC.title as inner_category_title',
            'GC.id as gad_focused_id',
            'IC.id as inner_category_id',
            'PB.focused_id',
            'PB.gi_sup_data as sup_data',
            'REC.status as record_status'
        ])
        ->from('gad_plan_budget PB')
        // ->leftJoin(['CF' => 'gad_ppa_client_focused'], 'CF.id = PB.ppa_focused_id')
        ->leftJoin(['GC' => 'gad_comment'], 'GC.plan_budget_id = PB.id')
        ->leftJoin(['GF' => 'gad_focused'], 'GF.id = PB.focused_id')
        ->leftJoin(['IC' => 'gad_inner_category'], 'IC.id = PB.inner_category_id')
        ->leftJoin(['REC' => 'gad_record'], 'REC.id = PB.record_id')
        ->where(['PB.record_tuc' => $ruc])
        ->orderBy(['PB.focused_id' => SORT_ASC,'PB.inner_category_id' => SORT_ASC,'PB.ppa_value' => SORT_ASC,'PB.id' => SORT_ASC])
        ->groupBy(['PB.focused_id','PB.inner_category_id','PB.ppa_value','PB.objective','PB.relevant_lgu_program_project','PB.activity','PB.performance_target'])
        ->all();
        // echo "<pre>";
        // print_r($dataPlanBudget); exit;

        $sum_dbp_mooe = 0;
        $sum_dbp_ps = 0;
        $sum_dbp_co = 0;
        $sum_db_budget = 0;
        foreach ($dataPlanBudget as $key => $dpb) {
            $sum_dbp_mooe += $dpb["budget_mooe"];
            $sum_dbp_ps += $dpb["budget_ps"];
            $sum_dbp_co += $dpb["budget_co"];
        }

        
        $sum_db_budget = ($sum_dbp_co + $sum_dbp_mooe + $sum_dbp_ps);
        $grand_total_pb = ($sum_db_budget + $varTotalGadAttributedProBudget);



        $objective_type = ArrayHelper::getColumn(GadPlanBudget::find()->select(['objective'])->distinct()->all(), 'objective');
        $relevant_type       = ArrayHelper::getColumn(GadPlanBudget::find()
                            ->select(['relevant_lgu_program_project'])
                            ->distinct()
                            ->all(), 'relevant_lgu_program_project');
        // $opt_org_focused = ArrayHelper::map(\common\models\GadPpaOrganizationalFocused::find()->all(), 'id', 'title');
        // $opt_cli_focused = ArrayHelper::map(\common\models\GadPpaClientFocused::find()->all(), 'id', 'title');

        $select_GadFocused = ArrayHelper::map(\common\models\GadFocused::find()->all(), 'id', 'title');
        $select_GadInnerCategory = ArrayHelper::map(\common\models\GadInnerCategory::find()->all(), 'id', 'title');
        $select_PpaAttributedProgram = ArrayHelper::map(\common\models\GadPpaAttributedProgram::find()->all(), 'id', 'title');
        $select_ActivityCategory = ArrayHelper::map(\common\models\GadActivityCategory::find()->all(), 'id', 'title');

        $reportStatus = 0;
        $modelRecord = GadRecord::find()->where(['tuc' => $ruc])->one();
        $qryReportStatus = $modelRecord->status;


        if($onstep == "to_create_gpb")
        {
            $renderValue = 'step_create_gpb';
        }
        else
        {
            // Yii::$app->session["encode_gender_pb"] = "closed";
            // Yii::$app->session["encode_attribute_pb"] = "closed";
            $renderValue = 'index';
        }

        return $this->render($renderValue, [
            'select_ActivityCategory' => $select_ActivityCategory,
            'dataRecord' => $dataRecord,
            'dataAttributedProgram' => $dataAttributedProgram,
            'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
            'dataPlanBudget' => $dataPlanBudget,
            'ruc' => $ruc,
            'objective_type' => $objective_type,
            'opt_org_focused' => [],
            'opt_cli_focused' => [],
            'relevant_type' => $relevant_type,
            'recRegion' => $recRegion,
            'recProvince' => $recProvince,
            'recCitymun' => $recCitymun,
            'recTotalGadBudget' => $recTotalGadBudget,
            'recTotalLguBudget' => $recTotalLguBudget,
            'onstep' => $onstep,
            'select_GadFocused' => $select_GadFocused,
            'select_GadInnerCategory' => $select_GadInnerCategory,
            'tocreate' => $tocreate,
            'grand_total_pb' => $grand_total_pb,
            'fivePercentTotalLguBudget' => $fivePercentTotalLguBudget,
            'qryReportStatus' => $qryReportStatus,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single GadPlanBudget model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($row_id,$model_name,$ruc,$onstep,$tocreate)
    {
        $qry = (new \yii\db\Query())
        ->select([
            'FT.title as folder_title',
            'FA.hash',
            'FA.model_name',
            'FA.model_id',
            'FA.file_name',
            'FA.extension',
            'FT.id as folder_id'
        ])
        ->from('gad_file_attached FA')
        ->leftJoin(['FT' => 'gad_file_folder_type'], 'FT.id = FA.file_folder_type_id')
        ->groupBy(['FA.file_folder_type_id','FA.id'])
        ->orderBy(['FA.file_folder_type_id' => SORT_ASC,'FA.id' => SORT_ASC])
        ->where(['FA.model_id' => $row_id, 'FA.model_name' => $model_name])
        ->all();
        // ->createCommand()->rawSql;
        // print_r($qry); exit;
        return $this->renderAjax('view', [
            'qry' => $qry,
            'ruc' => $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate
        ]);
    }

    public function actionDeleteUploadedFile($hash,$extension,$ruc,$tocreate,$onstep)
    {
        $hash_name = $hash.".".$extension;
        unlink(Yii::getAlias('@webroot')."/uploads/file_attached/".$hash_name);
        $qry = GadFileAttached::find()->where(['hash' => $hash])->one();
        $qry->delete();

        return $this->redirect(['index','ruc' => $ruc,'onstep' => $onstep,'tocreate' => $tocreate]);
    }

    public function actionDownloadUploadedFile($hash,$extension)
    {
        $hash_name = $hash.".".$extension;
        $path = Yii::getAlias('@webroot')."/uploads/file_attached/".$hash_name;
        $qry = GadFileAttached::find()->where(['hash' => $hash])->one();
        $file_name = !empty($qry->file_name) ? $qry->file_name.".".$extension : "";

        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path, $file_name);
        }
    }

    public function actionViewUploadedFile($hash,$extension)
    {

        $file = $hash.".".$extension;
        return $this->render('_view_uploaded_file', [
            'file' => $file,
            'extension' => $extension,
        ]);
    }

    /**
     * Creates a new GadPlanBudget model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GadPlanBudget();
        $region = ArrayHelper::map(Region::find()->all(), 'region_c', 'region_m');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'region' => $region,
        ]);
    }

    // /**
    //  * Updates an existing GadPlanBudget model.
    //  * If update is successful, the browser will be redirected to the 'view' page.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionUpdate($id,$ruc,$onstep,$tocreate)
    // {
    //     $model = new UploadForm();

    //     if (Yii::$app->request->isPost) {
    //         $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
    //         if ($model->upload()) {
    //             // file is uploaded successfully
    //             return;
    //         }
    //     }

    //     return $this->render('_upload_form', ['model' => $model]);
    // }

    public function actionUpdate($id,$ruc,$onstep,$tocreate){

           $upload = new GadFileAttached();
           $folder_type = ArrayHelper::map(\common\models\GadFileFolderType::find()->all(), 'id', 'title');

           if($upload->load(Yii::$app->request->post()))
           {
                $upload->file_name = UploadedFile::getInstances($upload,'file_name');
                if($upload->file_name)
                {
                    $basepath = Yii::getAlias('@app');
                    $imagepath= $basepath.'/web/uploads/file_attached/';
                    
                    $countLoop = 0;
                    foreach ($upload->file_name as $image) {
                        $modelName = "GadPlanBudget";
                        $countLoop += 1;
                        $model = new GadFileAttached();
                        $rand_name=rand(10,100);
                        $model->file_name = $image;
                        $model->model_id = $id;
                        $model->model_name = $modelName;
                        $miliseconds = round(microtime(true) * 1000);
                        $hash =  md5(date('Y-m-d')."-".date("h-i-sa")."-".$miliseconds.$rand_name.$countLoop.$modelName.$id);
                        $model->hash = $hash; 
                        $model->extension = $image->extension;
                        $model->file_folder_type_id = $upload->file_folder_type_id;


                        if($model->save(false))
                        {
                            $image->saveAs($imagepath.$hash.".".$image->extension);
                        }
                    }
                    $qry = GadPlanBudget::updateAll(['upload_status' => 2],'id = '.$id.' ');
                    return $this->redirect(['index','ruc' => $ruc,'onstep' => $onstep,'tocreate' => $tocreate]);
                }
           }
                

           return $this->renderAjax('_upload_form',[
                'upload'=>$upload,
                'folder_type' => $folder_type,
            ]);

    }

    /**
     * Deletes an existing GadPlanBudget model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the GadPlanBudget model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GadPlanBudget the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GadPlanBudget::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
