<?php

namespace common\modules\report\controllers;

use Yii;
use common\modules\report\controllers\DefaultController as Tools;
use common\models\GadRecord;
use common\models\GadPlanBudget;
use common\models\GadAttributedProgram;
use common\models\GadReportHistory;
use common\models\GadFileAttached;
use common\modules\report\models\GadRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;
use yii\helpers\ArrayHelper;
use common\models\GadStatus;
use common\models\GadYear;
use niksko12\auditlogs\classes\ControllerAudit;
use common\models\ArchiveHistory;
use common\models\GadPlanType;
/**
 * GadRecordController implements the CRUD actions for GadRecord model.
 */
class GadRecordController extends ControllerAudit
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

    public function actionArchive($report_type,$record_id)
    {
        $searchModel = new GadRecordSearch();
        $dataProvider = Yii::$app->session["GadRecordSearch"];
        $gadRecord = GadRecord::find()->where(['id' => $record_id])->one();
        $status_id = !empty($gadRecord->status) ? $gadRecord->status : null;
        $record_tuc = !empty($gadRecord->tuc) ? $gadRecord->tuc : null;
        $arrQue = [];
        $varArchiveByName = "";

        if(empty($record_id))
        {
            foreach ($dataProvider->query->all() as $key => $row) {
                date_default_timezone_set("Asia/Manila");
                $arrQue[] = $row["record_id"];
                $archiveHistory = new ArchiveHistory();
                $archiveHistory->record_id = $row["record_id"];
                $archiveHistory->record_tuc = $row["record_tuc"];
                $archiveHistory->archiveby_userid = Yii::$app->user->identity->id;
                if(Yii::$app->user->can("gad_admin") || Yii::$app->user->can("SuperAdministrator"))
                {
                    $archiveHistory->archiveby_name = "Super Administrator";
                }
                else
                {
                    $archiveHistory->archiveby_name = Yii::$app->user->identity->userinfo->FIRST_M." ".Yii::$app->user->identity->userinfo->LAST_M;
                }
                
                $archiveHistory->remarks = "Report has been archived (system_generated_remarks)";
                $archiveHistory->status = $row["record_status"];
                $archiveHistory->date_created = date("Y-m-d");
                $archiveHistory->time_created = date("h:i:sa");
                $archiveHistory->save();
            }
        }
        else
        {
            $archiveHistory = new ArchiveHistory();
            $archiveHistory->record_id = $record_id;
            $archiveHistory->record_tuc = $record_tuc;
            $archiveHistory->archiveby_userid = Yii::$app->user->identity->id;
            if(Yii::$app->user->can("gad_admin") || Yii::$app->user->can("SuperAdministrator"))
            {
                $archiveHistory->archiveby_name = "Super Administrator";
            }
            else
            {
                $archiveHistory->archiveby_name = Yii::$app->user->identity->userinfo->FIRST_M." ".Yii::$app->user->identity->userinfo->LAST_M;
            }
            
            $archiveHistory->remarks = "Report has been archived (system_generated_remarks)";
            $archiveHistory->status = $status_id;
            $archiveHistory->date_created = date("Y-m-d");
            $archiveHistory->time_created = date("h:i:sa");
            $archiveHistory->save();
        }
        

        GadRecord::updateAll(['is_archive' => 1],['id' => !empty($record_id) ? $record_id : $arrQue]);
        \Yii::$app->getSession()->setFlash('success', "Action has been performed");
        return $this->redirect(['index', 'report_type' => $report_type]);
    }

    public function actionTrack($ruc)
    {
        
        $qry = (new \yii\db\Query())
        ->select([
            'REG.abbreviation as region',
            'PRV.province_m as province',
            'CTC.citymun_m as citymun',
            'OFF.OFFICE_M as office',
            'HIS.fullname',
            'HIS.date_created',
            'HIS.time_created',
            'HIS.remarks',
            'HIS.status'
        ])
        ->from('gad_report_history HIS')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = HIS.responsible_region_c')
        ->leftJoin(['PRV' => 'tblprovince'], 'PRV.province_c = HIS.responsible_province_c')
        ->leftJoin(['OFF' => 'tbloffice'], 'OFF.OFFICE_C = HIS.responsible_office_c')
        ->leftJoin(['CTC' => 'tblcitymun'], 'CTC.citymun_c = HIS.responsible_citymun_c AND CTC.province_c = HIS.responsible_province_c')
        ->where(['HIS.tuc' => $ruc])
        ->groupBy(['HIS.id'])
        ->all();

        return $this->renderAjax('_track', [
            'qry' => $qry,
        ]);
    }

    public function GenerateRemarks($tuc)
    {
        $qryModel = \common\models\GadReportHistory::find()->where(['tuc' => $tuc])->orderBy(['id'=>SORT_DESC])->one();
        $value = !empty($qryModel->remarks) ? $qryModel->remarks : "";

        return $value;
    }

    public function GenerateLatestDate($tuc)
    {
        $qryModel = \common\models\GadReportHistory::find()->where(['tuc' => $tuc])->orderBy(['id'=>SORT_DESC])->one();
        

        return !empty($qryModel->date_created) ? date("F j, Y", strtotime(date($qryModel->date_created))) : "";
    }

    public function actionMultipleSubmit($report_type)
    {
        if($report_type == "plan_budget")
        {
            $reportValue = 1;
        }
        else
        {
            $reportValue = 2;
        }

        GadRecord::updateAll(['status' => 4],['status' => 3,'region_c' => Yii::$app->user->identity->userinfo->REGION_C,'report_type_id'=>$reportValue]);

        $qryThis = (new \yii\db\Query())
        ->select(["*"])
        ->from('gad_record REC')
        ->andWhere(['REC.status' => 3,'region_c' => Yii::$app->user->identity->userinfo->REGION_C])
        ->andWhere(['report_type_id' => $reportValue])
        ->groupBy(['REC.id'])
        ->all();

        $responsible_office_c = 0;
        if(Yii::$app->user->can("gad_region_permission"))
        {
            $responsible_office_c = 1;
        }
        else if(Yii::$app->user->can("gad_field_permission"))
        {
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS")
            {
                $responsible_office_c = 4;
            }
            else
            {
                $responsible_office_c = 3;
            }
        }

        $bulkInsertArray = array();
        foreach ($qryThis as $key => $row) {
            $bulkInsertArray[]=[
                'remarks' => 'Default remarks : Submitted to Central Office',
                'tuc'=>$row["tuc"],
                'status' => $row["status"],
                'responsible_office_c' => $responsible_office_c,
                'responsible_user_id' => Yii::$app->user->identity->id,
                'date_created' => date('Y-m-d'),
                'time_created' => date("h:i:sa"),
            ];
        }
        

        if(count($bulkInsertArray)>0){
            
            $columnNameArray=['remarks','tuc','status','responsible_office_c','responsible_user_id','date_created','time_created'];
            // below line insert all your record and return number of rows inserted
            $insertCount = Yii::$app->db->createCommand()
               ->batchInsert(
                     'gad_report_history', $columnNameArray, $bulkInsertArray
                 )
               ->execute();
        }

        \Yii::$app->getSession()->setFlash('success', "Action has been performed");
        return $this->redirect(['gad-record/index','report_type' => $report_type]);
    }

    /**
     * Lists all GadRecord models.
     * @return mixed
     */
    public function actionIndex($report_type)
    {
        $searchModel = new GadRecordSearch();

        $searchModel->report_type_id = $report_type == "plan_budget" ? 1 : 2;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $regionCondition = [];
        $provinceCondition = [];
        $citymunCondition = [];
        $statusCondition = [];
        $index_title = "";
        $urlReport = "";

        $firstYear = (int)date('Y') - 2;
        $lastYear = $firstYear + 1;
        $arrayYear = [];

        Yii::$app->session["activelink"] = $report_type;
        switch ($report_type) {
            case 'plan_budget':
                $dataProvider->query->andWhere(['GR.report_type_id' => 1]);
                $index_title = "List of GAD Plan and Budget";
                $urlReport = "gad-plan-budget/index";
                
            break;
            case 'accomplishment':
                $dataProvider->query->andWhere(['GR.report_type_id' => 2]);
                $index_title = "List of Accomplishment Report";
                $urlReport = "gad-accomplishment-report/index";
                
            break;
            
            default:
                throw new \yii\web\HttpException(404, 'The requested Page could not be found.');
            break;
        }

        if(Yii::$app->user->can("gad_lgu_permission")) // C/MLGOO
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $citymunCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C, 'citymun_c' => $searchModel->citymun_c  = Yii::$app->user->identity->userinfo->CITYMUN_C];

            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS")
            {
                $statusCondition = Tools::ViewStatus($report_type == "plan_budget" ? "gad_lgu_huc" : "ar_filtered_status_huc");
            }
            else
            {
                $statusCondition = Tools::ViewStatus($report_type == "plan_budget" ? "gad_lgu_non_huc" : "ar_filtered_status_lgu_ccm");
            }
        }
        else if(Yii::$app->user->can("gad_region_permission")) // Regional Office
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $statusCondition = Tools::ViewStatus($report_type == "plan_budget" ? "gad_region_dilg" : "ar_filtered_status_region");

            if(!empty($searchModel->citymun_c) || !empty($searchModel->province_c))
            {
                $citymunCondition = ['province_c' => $searchModel->province_c];
            }
            else
            {
                $citymunCondition = ['region_c' => 0];
            }
        }
        else if(Yii::$app->user->can("gad_province_permission")) // Provincial Office
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $citymunCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $statusCondition = Tools::ViewStatus($report_type == "plan_budget" ? "gad_province_dilg" : "ar_filtered_status_province_dilg");
        } 
        else if(Yii::$app->user->can("gad_lgu_province_permission"))
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $citymunCondition = ['citymun_c' => 'none'];
            $statusCondition = Tools::ViewStatus($report_type == "plan_budget" ? "gad_province_lgu" : "ar_filtered_status_lgu_province");
        }
        else if(Yii::$app->user->can("gad_ppdo_permission"))
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $citymunCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $statusCondition = Tools::ViewStatus($report_type == "plan_budget" ? "gad_ppdo" : "ar_filtered_status_ppdo");
        }
        else if(Yii::$app->user->can("gad_central_permission") || Yii::$app->user->can("gad_admin_permission"))
        {
            $provinceCondition = ['region_c' => $searchModel->region_c];
            $citymunCondition = ['province_c' => $searchModel->province_c];
            $statusCondition = Tools::ViewStatus("gad_all_status");
        }
        else
        {
            $provinceCondition = ['region_c' => $searchModel->region_c];
            $citymunCondition = ['province_c' => $searchModel->province_c];
            $statusCondition = Tools::ViewStatus($report_type == "plan_budget" ? "gad_all_status" : "ar_filtered_all_status");
        }

        $region = ArrayHelper::map(Region::find()->where($regionCondition)->all(), 'region_c', 'region_m');
        $province = ArrayHelper::map(Province::find()->where($provinceCondition)->all(), 'province_c', 'province_m');
        $citymun = ArrayHelper::map(Citymun::find()->where($citymunCondition)->all(), 'citymun_c', 'citymun_m');
        $statusList = ArrayHelper::map(GadStatus::find()->where(['code' => $statusCondition])->orderBy(['title' => SORT_ASC])->all(), 'code', 'title');
        $arrayYear = ArrayHelper::map(GadYear::find()->orderBy(['value' => SORT_DESC])->all(), 'value', 'value');
        $plan_type_title = ArrayHelper::map(GadPlanType::find()->all(), 'code', 'title');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'index_title' => $index_title,
            'urlReport' => $urlReport,
            'report_type' =>  $report_type,
            'region' => $region,
            'province' => $province,
            'citymun' => $citymun,
            'statusList' => $statusList,
            'arrayYear' => $arrayYear,
            'plan_type_title' => $plan_type_title
        ]);
    }

    /**
     * Displays a single GadRecord model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new GadRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($ruc,$onstep,$tocreate)
    {
        // print_r(Yii::$app->session['activelink']); exit;
        $model = new GadRecord();
        $model->region_c = Yii::$app->user->identity->userinfo->region->region_c;
        $model->province_c = Yii::$app->user->identity->userinfo->province->province_c;
        $create_plan_status = ArrayHelper::map(\common\models\CreateStatus::find()->all(), "code","title");
        $plan_type = ArrayHelper::map(\common\models\GadPlanType::find()->all(), "code","title");
        Yii::$app->session["activelink"] = $tocreate;

        $filteredByRole = [];
        
        if(Yii::$app->user->can("gad_lgu_permission"))
        {
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS")
            {
                $filteredByRole = ['province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,'citymun_c' => Yii::$app->user->identity->userinfo->CITYMUN_C,'status'=>Tools::ViewStatus('filter_endorsed_plan')];
            }
            else
            {
                $filteredByRole = ['province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,'citymun_c' => Yii::$app->user->identity->userinfo->CITYMUN_C,'status' => Tools::ViewStatus('filter_endorsed_plan')];
            }
        }
        else if(Yii::$app->user->can("gad_lgu_province_permission")) // all plan submitted by this province
        {
            $filteredByRole = ['province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C,
            'status' => Tools::ViewStatus('filter_endorsed_plan'),'office_c' => 2];
        }

        $query_all_existing_plan = GadRecord::find()
        ->where($filteredByRole)
        ->andWhere(['is_archive' => 0,'report_type_id' => 1])
        ->andWhere(['<>','plan_type_code', [2,3]])
        ->all();
        // ->createCommand()->rawSql;
        // print_r($query_all_existing_plan); exit;

        if(Yii::$app->user->can("gad_lgu_province_permission"))
        {
            $model->citymun_c = NULL;
            $model->isdilg = 0;
            $model->office_c = 2;
            if($tocreate == "gad_plan_budget")
            {
                $model->status = 9;
            }
            else // AR
            {
                $model->status = 37;
            }
        }
        else if(Yii::$app->user->can("gad_lgu_permission"))
        {
            $model->citymun_c = Yii::$app->user->identity->userinfo->citymun->citymun_c;
            $model->isdilg = 0;
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS"){ 
                $model->office_c = 4; //city office
                if($tocreate == "gad_plan_budget")
                {
                    $model->status = 8; 
                }
                else // AR
                {
                    $model->status = 35; 
                }
            }
            else // CC/M
            {
                $model->office_c = 3;
                if($tocreate == "gad_plan_budget")
                {
                    $model->status = 0; // encoding non HUC
                }
                else // AR
                {
                    $model->status = 36; 
                }
            }
        }
        
        $model->user_id = Yii::$app->user->identity->userinfo->user_id;
        date_default_timezone_set("Asia/Manila");
        $model->date_created = date('Y-m-d');
        $model->time_created = date("h:i:sa");
        $model->report_type_id = $tocreate == "gad_plan_budget" ? 1 : 2;
        $model->footer_date = date('Y-m-d');

        $modelUpdate = GadRecord::find()->where(['tuc' => $ruc])->one();

        $current_for_revision_record_id = !empty($modelUpdate->for_revision_record_id) ? $modelUpdate->for_revision_record_id : null;
        // --------- loading of data to fields
        if($onstep == "create_new")
        {

        }
        else
        {
            if($modelUpdate->plan_type_code == 1) // new plan
            {
                $modelUpdate->supplemental_record_id = null;
                $modelUpdate->for_revision_record_id = null;
                $modelUpdate->has_additional_lgu_budget = null;
            }
            else
            {
                if($modelUpdate->plan_type_code == 2) // supplemental
                {
                    $modelUpdate->for_revision_record_id = null;
                }
                else // for revision
                {
                    $modelUpdate->supplemental_record_id = $modelUpdate->for_revision_record_id;
                    $modelUpdate->total_lgu_budget = null;
                    $modelUpdate->has_additional_lgu_budget = null;
                }
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            $post_data = Yii::$app->request->post();
            $post_supplemental_record_id = $post_data['GadRecord']['supplemental_record_id'];
            $post_year = $post_data['GadRecord']['year'];

            if($onstep == "to_create_gpb") // during the process of updating primary information of plan
            {
                $modelUpdate->total_lgu_budget = $model->total_lgu_budget;
                $modelUpdate->year = $model->year;
                $modelUpdate->plan_type_code = $model->plan_type_code;

                if($model->plan_type_code == 2 || $model->plan_type_code == 3) // supplemental or for revision plan
                {
                    if($model->plan_type_code == 3) // for revision
                    {
                        $modelUpdate->has_additional_lgu_budget = null;
                        $modelUpdate->for_revision_record_id = $post_supplemental_record_id;
                        $modelUpdate->supplemental_record_id = null;
                        $modelUpdate->total_lgu_budget = null;
                        $modelUpdate->year = Tools::GetRecordYearById($model->supplemental_record_id);
                        $modelUpdate->attached_ar_record_id = Tools::GetAttachedArById($model->supplemental_record_id);

                        $sup_record_tuc = Tools::GetRucById($model->supplemental_record_id);
                        $query_plan_data = GadPlanBudget::find()->where(['record_tuc' => $sup_record_tuc])->all();
                        $plan_ids = [];
                        if($model->supplemental_record_id != $current_for_revision_record_id)
                        {
                            if(GadPlanBudget::deleteAll(['record_tuc' => $ruc]))
                            {
                                foreach ($query_plan_data as $keyplan => $row) {
                                    $gpb_model = new GadPlanBudget();

                                    $plan_ids[] = $row['id'];
                                    $gpb_model->old_plan_id = $row['id'];
                                    $gpb_model->record_id = Tools::GetRecordIdByRuc($ruc);
                                    $gpb_model->focused_id = $row['focused_id'];
                                    $gpb_model->inner_category_id = $row['inner_category_id'];
                                    $gpb_model->gi_sup_data = $row['gi_sup_data'];
                                    $gpb_model->source = $row['source'];
                                    $gpb_model->cliorg_ppa_attributed_program_id = $row['cliorg_ppa_attributed_program_id']; 
                                    $gpb_model->ppa_value = $row['ppa_value'];
                                    $gpb_model->objective = $row['objective'];
                                    $gpb_model->relevant_lgu_program_project = $row['relevant_lgu_program_project'];
                                    $gpb_model->activity_category_id = $row['activity_category_id'];
                                    $gpb_model->activity = $row['activity'];
                                    $gpb_model->date_implement_start = $row['date_implement_start'];
                                    $gpb_model->date_implement_end = $row['date_implement_end'];
                                    $gpb_model->performance_target = $row['performance_target'];
                                    $gpb_model->budget_mooe = $row['budget_mooe'];
                                    $gpb_model->budget_ps = $row['budget_ps'];
                                    $gpb_model->budget_co = $row['budget_co'];
                                    $gpb_model->lead_responsible_office = $row['lead_responsible_office'];
                                    $gpb_model->record_tuc = $ruc;
                                    $gpb_model->date_created = date('Y-m-d');
                                    $gpb_model->time_created = date("h:i:sa");
                                    $gpb_model->save(false);
                                }
                            }
                            else
                            {
                                throw new \yii\web\HttpException(403, 'Connection Error');
                            }

                            $query_attrib_program = GadAttributedProgram::find()->where(['record_tuc' => $sup_record_tuc])->all();

                            if(GadAttributedProgram::deleteAll(['record_tuc' => $ruc]))
                            {
                                foreach ($query_attrib_program as $keyap => $row1) {
                                    $ap_model = new GadAttributedProgram();

                                    $ap_model->record_id = Tools::GetRecordIdByRuc($ruc);
                                    $ap_model->record_tuc = $ruc;
                                    $ap_model->old_row_id = $row1['id'];
                                    $ap_model->controller_id = $row1['controller_id'];
                                    $ap_model->ppa_attributed_program_id = $row1['ppa_attributed_program_id'];
                                    $ap_model->lgu_program_project = $row1['lgu_program_project'];
                                    $ap_model->checklist_id = $row1['checklist_id'];
                                    $ap_model->hgdg = $row1['hgdg'];
                                    $ap_model->total_annual_pro_budget = $row1['total_annual_pro_budget'];
                                    $ap_model->ap_lead_responsible_office = $row1['ap_lead_responsible_office'];
                                    $ap_model->date_created = date('Y-m-d');
                                    $ap_model->time_created = date("h:i:sa");
                                    $ap_model->save(false);
                                }
                            }
                            else
                            {
                                throw new \yii\web\HttpException(403, 'Connection Error');
                            }
                        }
                    }
                    else // new
                    {
                        $modelUpdate->supplemental_record_id = $model->supplemental_record_id;
                        $modelUpdate->year = Tools::GetRecordYearById($model->supplemental_record_id); // get year of record by id inserted in supplemental field
                        $modelUpdate->has_additional_lgu_budget = $model->has_additional_lgu_budget;
                        $modelUpdate->for_revision_record_id = null;

                        if($model->has_additional_lgu_budget == "yes") // if has additional lgu budget
                        {
                            $modelUpdate->total_lgu_budget = $model->total_lgu_budget;
                        }
                        else // if no additional lgu budget
                        {
                            $modelUpdate->total_lgu_budget = null;
                        }
                    }
                }
                else // new plan
                {
                    $modelUpdate->supplemental_record_id = null;
                    $modelUpdate->has_additional_lgu_budget = null;
                    $modelUpdate->for_revision_record_id = null;
                }
                
                $modelUpdate->save(false);   
            }
            else // creating new plan
            {
                $miliseconds = round(microtime(true) * 1000);
                $hash =  md5(date('Y-m-d')."-".date("h-i-sa")."-".$miliseconds);
                $model->tuc = $hash;

                if($tocreate == "gad_plan_budget")
                {
                    if($model->plan_type_code == 1) // new plan
                    {
                        $model->supplemental_record_id = null;
                        $model->has_additional_lgu_budget = null;
                        $model->for_revision_record_id = null;
                    }
                    else // supplemental plan or for revision plan
                    {
                        $model->year = Tools::GetRecordYearById($model->supplemental_record_id);
                        $model->for_revision_record_id = null;

                        if($model->has_additional_lgu_budget == "no")
                        {
                            $model->total_lgu_budget = null;
                        }

                        if($model->plan_type_code == 3) // for revision
                        {
                            $model->for_revision_record_id = $model->supplemental_record_id;
                            $model->attached_ar_record_id = Tools::GetAttachedArById($model->supplemental_record_id);
                            $model->has_additional_lgu_budget = null;
                            $model->total_lgu_budget = null;
                            $model->save(false);

                            $sup_record_tuc = Tools::GetRucById($model->supplemental_record_id);
                            $query_plan_data = GadPlanBudget::find()->where(['record_tuc' => $sup_record_tuc])
                            // ->createCommand()->rawSql;
                            ->all();
                            
                            foreach ($query_plan_data as $keyplan2 => $row2) {
                                $gpb_model = new GadPlanBudget();

                                $gpb_model->old_plan_id = $row2['id'];
                                $gpb_model->record_id = $model->id;
                                $gpb_model->focused_id = $row2['focused_id'];
                                $gpb_model->inner_category_id = $row2['inner_category_id'];
                                $gpb_model->gi_sup_data = $row2['gi_sup_data'];
                                $gpb_model->source = $row2['source'];
                                $gpb_model->cliorg_ppa_attributed_program_id = $row2['cliorg_ppa_attributed_program_id']; 
                                $gpb_model->ppa_value = $row2['ppa_value'];
                                $gpb_model->objective = $row2['objective'];
                                $gpb_model->relevant_lgu_program_project = $row2['relevant_lgu_program_project'];
                                $gpb_model->activity_category_id = $row2['activity_category_id'];
                                $gpb_model->activity = $row2['activity'];
                                $gpb_model->date_implement_start = $row2['date_implement_start'];
                                $gpb_model->date_implement_end = $row2['date_implement_end'];
                                $gpb_model->performance_target = $row2['performance_target'];
                                $gpb_model->budget_mooe = $row2['budget_mooe'];
                                $gpb_model->budget_ps = $row2['budget_ps'];
                                $gpb_model->budget_co = $row2['budget_co'];
                                $gpb_model->lead_responsible_office = $row2['lead_responsible_office'];
                                $gpb_model->record_tuc = $hash;
                                $gpb_model->save(false);
                            }

                            $query_attrib_program = GadAttributedProgram::find()->where(['record_tuc' => $sup_record_tuc])->all();
                            
                            foreach ($query_attrib_program as $keyap2 => $row3) {
                                $ap_model = new GadAttributedProgram();

                                $ap_model->record_id = $model->id;
                                $ap_model->record_tuc = $hash;
                                $ap_model->old_row_id = $row3['id'];
                                $ap_model->controller_id = $row3['controller_id'];
                                $ap_model->ppa_attributed_program_id = $row3['ppa_attributed_program_id'];
                                $ap_model->lgu_program_project = $row3['lgu_program_project'];
                                $ap_model->checklist_id = $row3['checklist_id'];
                                $ap_model->hgdg = $row3['hgdg'];
                                $ap_model->total_annual_pro_budget = $row3['total_annual_pro_budget'];
                                $ap_model->ap_lead_responsible_office = $row3['ap_lead_responsible_office'];
                                $ap_model->date_created = date('Y-m-d');
                                $ap_model->time_created = date("h:i:sa");
                                $ap_model->save(false);
                            }
                        }
                    }
                }

                $model->save();
                // Storing History after Creating GPB
                if(Yii::$app->user->can("gad_lgu_province_permission"))
                {
                    if($tocreate == "gad_plan_budget")
                    {
                        Tools::actionCreateReportHistory("Default Remarks : Encoded Primary Information",9,$hash,"","");
                    }
                    else
                    {
                        Tools::actionCreateReportHistory("Default Remarks : Encoded Primary Information",37,$hash,"","");
                    }
                }
                else if(Yii::$app->user->can("gad_lgu_permission"))
                {
                    if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS"){ 
                        
                        if($tocreate == "gad_plan_budget")
                        {
                            Tools::actionCreateReportHistory("Default Remarks : Encoded Primary Information",8,$hash,"","");
                        }
                        else
                        {
                            Tools::actionCreateReportHistory("Default Remarks : Encoded Primary Information",35,$hash,"","");
                        }
                    }
                    else
                    {
                        if($tocreate == "gad_plan_budget")
                        {
                            Tools::actionCreateReportHistory("Default Remarks : Encoded Primary Information",0,$hash,"","");
                        }
                        else
                        {
                            Tools::actionCreateReportHistory("Default Remarks : Encoded Primary Information",36,$hash,"","");
                        }
                    }
                }
            }

            $urlReportIndex = "";
            $onstepValue = "";
            if($tocreate == "accomp_report")
            {
                $urlReportIndex = '/report/gad-accomplishment-report/index';
                $onstepValue = "to_create_ar";
                Yii::$app->session["encode_gender_ar"] = "open";
                Yii::$app->session["encode_attribute_ar"] = "open";
            }
            else
            {
                $urlReportIndex = '/report/gad-plan-budget/index';
                $onstepValue = "to_create_gpb";
                Yii::$app->session["encode_gender_pb"] = "open";
                Yii::$app->session["encode_attribute_pb"] = "open";
            }
            
            // $ruc if back to step 1 use $ruc to update the record
            // $hash after saving record or the 1st step, this hash will be used to fill up report
            return $this->redirect([$urlReportIndex, 
                'ruc'       => $onstep == "to_create_gpb" ? $ruc : $hash,
                'onstep'    => $onstepValue,
                'tocreate'  => $tocreate,
                'plan_type' => $plan_type,
            ]);
        }

        return $this->render('create', [
            // if onstep has this values just update record
            'model' => $onstep == "to_create_gpb" || $onstep == "to_create_ar" ? $modelUpdate : $model, 
            'ruc' =>  $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate,
            'create_plan_status' => $create_plan_status,
            'plan_type' => $plan_type,
            'query_all_existing_plan' => $query_all_existing_plan
        ]);
    }

    public function actionEditForm($ruc,$onstep,$tocreate)
    {

        $model = $this->findModel(Tools::GetRecordIdByRuc($ruc));

        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            if($tocreate == "accomp_report")
            {
                return $this->redirect(['gad-accomplishment-report/index', 'ruc' => $ruc,'onstep' =>  $onstep, 'tocreate' => $tocreate]);
            }
            else
            {
                return $this->redirect(['gad-plan-budget/index', 'ruc' => $ruc,'onstep' =>  $onstep, 'tocreate' => $tocreate]);
            }
        }

        return $this->renderAjax('_edit_form', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GadRecord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GadRecord model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $qry = GadRecord::find()->where(['id' => $id])->one();
        $report_type = !empty($qry->report_type_id) ? $qry->report_type_id : "";

        if($report_type == 1)
        {
            $this->findModel($id)->delete();
            return $this->redirect(['index','report_type' => 'plan_budget']);
        }
        else
        {
            $this->findModel($id)->delete();
            return $this->redirect(['index','report_type' => 'accomplishment']);
        }
    }

    /**
     * Finds the GadRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GadRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GadRecord::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
