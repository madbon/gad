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
use niksko12\user\models\User;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\GadFileAttached;
use common\models\GadAttributedProgram;
use yii\db\Expression;
use common\modules\report\controllers\DefaultController as Tools;
use niksko12\auditlogs\classes\ControllerAudit;
use common\models\GadReportHistory;



/**
 * GadPlanBudgetController implements the CRUD actions for GadPlanBudget model.
 */
class GadPlanBudgetController extends ControllerAudit
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

    public function actionCancel($ruc,$status,$onstep,$tocreate)
    {
        GadRecord::updateAll(['status' => $status], 'tuc = "'.$ruc.'" ');

        date_default_timezone_set("Asia/Manila");
        $model = new GadReportHistory();
        $model->remarks = "";
        $model->tuc = $ruc;
        $model->status = $status;
        $model->date_created = date('Y-m-d');
        $model->time_created = date("h:i:sa");
        $model->responsible_user_id = !empty(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : "";
        $model->responsible_region_c = !empty(Yii::$app->user->identity->userinfo->REGION_C) ? Yii::$app->user->identity->userinfo->REGION_C : "";
        $model->responsible_province_c = !empty(Yii::$app->user->identity->userinfo->PROVINCE_C) ? Yii::$app->user->identity->userinfo->PROVINCE_C : "";
        $model->responsible_citymun_c = !empty(Yii::$app->user->identity->userinfo->CITYMUN_C) ? Yii::$app->user->identity->userinfo->CITYMUN_C : "";
        $model->fullname = Yii::$app->user->identity->userinfo->FIRST_M." ".Yii::$app->user->identity->userinfo->LAST_M;
        $model->responsible_office_c = !empty(Yii::$app->user->identity->userinfo->OFFICE_C) ? Yii::$app->user->identity->userinfo->OFFICE_C : "";
        $model->save();

        return $this->redirect(['index', 'ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate]);
    }

    public function actionDeleteAll($ruc,$onstep,$tocreate)
    {
        GadPlanBudget::deleteAll(['record_tuc' => $ruc]);
        return $this->redirect(['index', 'ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate]);
    }

    public function actionDeleteAllAttrib($ruc,$onstep,$tocreate)
    {
        GadAttributedProgram::deleteAll(['record_tuc' => $ruc]);
        return $this->redirect(['index', 'ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate]);
    }

    public function actionLoadAr($ruc,$recordOne_attached_ar_record_id)
    {
        $condition = [];
        $condition2 = [];
        $condition3 = [];
        if(Yii::$app->user->can("gad_lgu_permission"))
        {
            $condition = ['REC.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C, 'REC.citymun_c' => Yii::$app->user->identity->userinfo->CITYMUN_C];
        }
        else if(Yii::$app->user->can("gad_lgu_province_permission"))
        {
            $condition = ['REC.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C, 'REC.citymun_c' => null, 'REC.office_c' => 2];
        }

        $arrComma = [];
        $QueryComma = GadRecord::find()
        ->select(['attached_ar_record_id'])
        ->where(['not',['attached_ar_record_id' => null]])
        ->andWhere(['is_archive' => 0])
        ->all();

        foreach ($QueryComma as $key => $row) {
            # code...
            $arrComma[] = $row["attached_ar_record_id"];
        }

        $QueryGetArId = GadRecord::find()->where(['tuc' => $ruc])->andWhere(['is_archive' => 0])->one();

        $arrComma2 = [];
        $QueryComma2 = GadRecord::find()
        ->select(["id"])
        ->where(['not',['id' => $arrComma]])
        ->andWhere(['report_type_id' => 2])
        ->andWhere(['is_archive' => 0])
        ->orWhere(['id' => $QueryGetArId->attached_ar_record_id])
        ->all();

        foreach ($QueryComma2 as $key => $row2) {
            $arrComma2[] = $row2["id"];
        }

        if(empty($QueryGetArId->attached_ar_record_id))
        {
            $condition2 = ['not',['REC.id' => $arrComma]];
        }
        else
        {
            // $condition3 = ['REC.id' => $QueryGetArId->attached_ar_record_id];
            $condition2 = ['in','REC.id',$arrComma2];
        }


        $qry = (new \yii\db\Query())
        ->select([
            'OFF.OFFICE_M as office_name',
            'PRV.province_m as province_name',
            'CTC.citymun_m as citymun_name',
            'REC.status as record_status',
            'REC.total_lgu_budget',
            'REC.year',
            'REC.prepared_by',
            'REC.approved_by',
            'REC.id as record_id',
            'REC.attached_ar_record_id as ar_id',
            'REC.tuc as ruc'
        ])
        ->from('gad_record REC')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = REC.region_c')
        ->leftJoin(['PRV' => 'tblprovince'], 'PRV.province_c = REC.province_c')
        ->leftJoin(['CTC' => 'tblcitymun'], 'CTC.citymun_c = REC.citymun_c AND CTC.province_c = REC.province_c')
        ->leftJoin(['OFF' => 'tbloffice'], 'OFF.OFFICE_C = REC.office_c')
        ->where(['REC.report_type_id' => 2,'REC.is_archive' => 0])
        ->andWhere($condition)
        ->andWhere(['REC.is_archive' => 0])
        ->andFilterWhere($condition2)
        ->andFilterWhere(['REC.id' => $recordOne_attached_ar_record_id])
        ->groupBy(['REC.id'])
        ->orderBy(['REC.id' => SORT_DESC])
        ->all();

        return $this->renderAjax('_view_list_accomplishment',[
            'qry' => $qry,
            'recordOne_attached_ar_record_id' => $recordOne_attached_ar_record_id,
            'ruc' => $ruc
        ]);
    }

    public function actionLoadPlan($ruc,$onstep,$tocreate)
    {
        $query_record = GadRecord::find()->where(['tuc' => $ruc])->one();
        $for_revision_record_id = $query_record->for_revision_record_id;
        $record_id = $query_record->id;

        $query = GadPlanBudget::find()->where(['record_id' => $for_revision_record_id])->groupBy(['id'])->distinct()->all();
       
        date_default_timezone_set("Asia/Manila");

        foreach ($query as $key => $row) {
            $model = new GadPlanBudget();
            $model->record_id = $record_id;
            $model->focused_id = $row['focused_id'];
            $model->inner_category_id = $row['inner_category_id'];
            $model->gi_sup_data = $row['gi_sup_data'];
            $model->source = $row['source'];
            $model->cliorg_ppa_attributed_program_id = $row['cliorg_ppa_attributed_program_id'];
            $model->ppa_focused_id = $row['ppa_focused_id'];
            $model->ppa_value = $row['ppa_value'];
            $model->cause_gender_issue = $row['cause_gender_issue'];
            $model->objective = $row['objective'];
            $model->relevant_lgu_program_project = $row['relevant_lgu_program_project'];
            $model->activity_category_id = $row['activity_category_id'];
            $model->activity = $row['activity'];
            $model->date_implement_start = $row['date_implement_start'];
            $model->date_implement_end = $row['date_implement_end'];
            $model->performance_target = $row['performance_target'];
            $model->budget_mooe = $row['budget_mooe'];
            $model->budget_ps = $row['budget_ps'];
            $model->budget_co = $row['budget_co'];
            $model->lead_responsible_office = $row['lead_responsible_office'];
            $model->date_created = date('Y-m-d');
            $model->time_created = date("h:i:sa");
            $model->record_tuc = $ruc;
            $model->upload_status = $row['upload_status'];
            $model->old_plan_id = $row["id"];
            $model->save(false);
        }
        
        return $this->redirect(['index', 'ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate]);
    }

    public function actionLoadFile($ruc,$onstep,$tocreate)
    {
        $query_record = GadRecord::find()->where(['tuc' => $ruc])->one();
        $record_id = $query_record->id;

        $queryFileAttached = (new \yii\db\Query())
        ->select([
            'FILE.id',
            'FILE.file_name',
            'FILE.model_name',
            'FILE.hash',
            'FILE.extension',
            'FILE.file_folder_type_id',
            'FILE.model_id',
            'PLAN.id as plan_id'
        ])
        ->from('gad_file_attached FILE')
        ->leftJoin(['PLAN' => 'gad_plan_budget'], 'PLAN.old_plan_id = FILE.model_id')
        ->where(['FILE.model_name' => 'GadPlanBudget', 'PLAN.record_id' => $record_id])
        ->groupBy(['FILE.id'])
        ->all();

        // echo "<pre>";
        // print_r($queryFileAttached);  exit;

        foreach ($queryFileAttached as $key1 => $row1) {

            $model2 = new GadFileAttached();
            $model2->model_id = $row1['plan_id'];
            $model2->file_name = $row1['file_name'];
            $model2->model_name = $row1['model_name'];
            $model2->hash = $row1['hash'];
            $model2->extension = $row1['extension'];
            $model2->file_folder_type_id = $row1['file_folder_type_id'];
            $model2->save(false);
        }
        return $this->redirect(['index', 'ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate]);
    }

    public function GetGadBudgetByRuc($ruc)
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
        ->groupBy(['AP.id'])
        ->orderBy(['AP.id' => SORT_ASC,'AP.lgu_program_project' => SORT_ASC])
        ->all();

        $varTotalGadAttributedProBudget = 0;
        foreach ($dataAttributedProgram as $key => $dap) {
            $varHgdg = $dap["hgdg"];
            $varTotalAnnualProBudget = $dap["total_annual_pro_budget"];
            $computeGadAttributedProBudget = 0;
            $HgdgMessage = null;
            $HgdgWrongSign = "";
            
            if((float)$varHgdg < 4) // 0%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if((float)$varHgdg >= 4 && (float)$varHgdg <= 7.99) // 25%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.25);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if((float)$varHgdg >= 8 && (float)$varHgdg <= 14.99) // 50%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.50);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if((float)$varHgdg <= 19.99 && (float)$varHgdg >= 15) // 75%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.75);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if((float)$varHgdg == 20) // 100%
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
        ->groupBy(['PB.id'])
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

        return $grand_total_pb;
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
        ->groupBy(['AP.id'])
        ->orderBy(['AP.id' => SORT_ASC,'AP.lgu_program_project' => SORT_ASC])
        ->all();

        $varTotalGadAttributedProBudget = 0;
        foreach ($dataAttributedProgram as $key => $dap) {
            $varHgdg = $dap["hgdg"];
            $varTotalAnnualProBudget = $dap["total_annual_pro_budget"];
            $computeGadAttributedProBudget = 0;
            $HgdgMessage = null;
            $HgdgWrongSign = "";
            
            if((float)$varHgdg < 4) // 0%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if((float)$varHgdg >= 4 && (float)$varHgdg <= 7.99) // 25%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.25);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if((float)$varHgdg >= 8 && (float)$varHgdg <= 14.99) // 50%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.50);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if((float)$varHgdg <= 19.99 && (float)$varHgdg >= 15) // 75%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.75);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if((float)$varHgdg == 20) // 100%
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
        ->groupBy(['PB.id'])
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

    public function actionFormChangeReportStatus($qryReportStatus, $ruc, $onstep,$tocreate)
    {
        return $this->renderAjax('_form_change_report_status', [
            'qryReportStatus' => $qryReportStatus,
            'ruc' => $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate
        ]);
    }

    // public function actionSubmitReport($)

    public function ChangeReportStatus($status,$tuc)
    {
        $qry = GadRecord::find()->where(['tuc' => $tuc])->one();
        $qryStatus = \common\models\GadStatus::find()->where(['code' => $status])->one();
        $statusTitle = !empty($qryStatus->title) ? $qryStatus->title : "";
        $conditionAssTitle = [];
        $andFilterValue =  [];

        $sourceMailContent = (new \yii\db\Query())
        ->select([
            'REG.region_m',
            'PROV.province_m',
            'CITY.citymun_m',
            'REC.year',
            'REC.total_lgu_budget',
            'REC.prepared_by',
            'REC.approved_by'
        ])
        ->from('gad_record REC')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = REC.region_c')
        ->leftJoin(['PROV' => 'tblprovince'], 'PROV.province_c = REC.province_c')
        ->leftJoin(['CITY' => 'tblcitymun'], 'CITY.citymun_c = REC.citymun_c AND CITY.province_c = REC.province_c')
        ->where(['REC.tuc' => $tuc])
        ->one();

        $region_name = !empty($sourceMailContent['region_m']) ? $sourceMailContent['region_m'] : "";
        $province_name = !empty($sourceMailContent['province_m']) ? $sourceMailContent['province_m'] : "";
        $citymun_name = !empty($sourceMailContent['citymun_m']) ? $sourceMailContent['citymun_m'] : "";
        $report_year = !empty($sourceMailContent['year']) ? $sourceMailContent['year'] : "";
        $total_lgu_budget = !empty($sourceMailContent['total_lgu_budget']) ? $sourceMailContent['total_lgu_budget'] : "";
        $total_gad_budget = GadPlanBudgetController::ComputeGadBudget($tuc);
        $prepared_by = !empty($sourceMailContent['prepared_by']) ? $sourceMailContent['prepared_by'] : "";
        $approved_by = !empty($sourceMailContent['approved_by']) ? $sourceMailContent['approved_by'] : "";

        if($status == 1) // For Review by PPDO
        {
            $conditionAssTitle = ['ASS.item_name' => ['gad_ppdo']];
            $andFilterValue = ['UI.PROVINCE_C' => Yii::$app->user->identity->userinfo->PROVINCE_C];
        }
        else if($status == 2) // Submitted to DILG Provincial Office
        {
            $conditionAssTitle = ['ASS.item_name' => ['gad_province']];
            $andFilterValue = ['UI.PROVINCE_C' => Yii::$app->user->identity->userinfo->PROVINCE_C];
        }
        else if($status == 3) // Submitted to Regional Office
        {
            $conditionAssTitle = ['ASS.item_name' => ['gad_region']];
            $andFilterValue = ['UI.REGION_C' => Yii::$app->user->identity->userinfo->REGION_C];
        }
        else if($status == 6) // Returned to LGU by Regional Office
        {
            $andFilterValue = ['REC.tuc' => $tuc];
        }
        else if($status == 7) // Returned to LGU C/M Office by PPDO
        {
            $andFilterValue = ['REC.tuc' => $tuc];
        }
        else if($status == 10) // Endorsed by DILG Region
        {
           $andFilterValue = ['REC.tuc' => $tuc];
        }

        $userAssignment = (new \yii\db\Query())
        ->select([
            'UI.user_id'
        ])
        ->from('user_info UI')
        ->leftJoin(['ASS' => 'auth_assignment'], 'ASS.user_id = UI.user_id')
        ->leftJoin(['REC' => 'gad_record'], 'REC.user_id = UI.user_id')
        ->andFilterWhere($conditionAssTitle)
        ->andFilterWhere($andFilterValue)
        ->one();
        $userAssignmentUserId = !empty($userAssignment['user_id']) ? $userAssignment['user_id'] : "";

        if(User::find()->where(['id' => $userAssignmentUserId])->exists())
        {
            $user = User::find()->where(['id' => $userAssignmentUserId])->One();
            $user->sendMail($statusTitle,"GAD Plan and Budget Monitoring System | auto-generated message | Region :".$region_name." | Province : ".$province_name." | City/Municipality : ".$citymun_name." | GAD Plan and Budget FY. ".$report_year." | Total LGU Budget : ".$total_lgu_budget." | Total GAD Budget : ".$total_gad_budget." | Prepared By : ".$prepared_by." | Approved By : ".$approved_by." ");
        }
        

        // updating footer date
        if($status == 1)
        {
            $qry->status = $status;
            $qry->footer_date = date("Y-m-d");
        }
        else if($status == 3)
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
        /*if(!$qry->save())
        {
            // print_r($qry->errors); exit;
        }*/

        // if($onstep == "to_create_ar")
        // {
        //     $redirectTo = "gad-accomplishment-report/index";
        // }
        // else
        // {
        //     $redirectTo = "gad-plan-budget/index";
        // }

        // \Yii::$app->getSession()->setFlash('success', "Action has been performed");
        // return $this->redirect([$redirectTo, 'ruc' => $tuc,'onstep' => $onstep, 'tocreate' => $tocreate]);
    }

    /**
     * Lists all GadPlanBudget models.
     * @return mixed
     */
    public function actionIndex($ruc,$onstep,$tocreate)
    {

        Yii::$app->session["record_tuc"] = $ruc;
        $searchModel = new GadPlanBudgetSearch();

        $model = new GadPlanBudget();
        $folder_type = ArrayHelper::map(\common\models\GadFileFolderType::find()->all(), 'id', 'title');
        $upload = new GadFileAttached();
        Yii::$app->session["activelink"] = $tocreate;
        $grand_total_pb = 0;
        $dataRecord = GadRecord::find()->where(['tuc' => $ruc, 'report_type_id' => 1])->all();
        Yii::$app->session['session_dataPlanRecord'] = $dataRecord;
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
        ->groupBy(['AP.lgu_program_project','AP.id'])
        ->orderBy(['AP.id' => SORT_ASC,'AP.lgu_program_project' => SORT_ASC])
        ->all();
        Yii::$app->session['session_dataPlanAttributedProgram'] = $dataAttributedProgram;

        $sum_ap_apb = 0;
        $varTotalGadAttributedProBudget = 0;
        foreach ($dataAttributedProgram as $key => $dap) {
            $varHgdg = $dap["hgdg"];
            $varTotalAnnualProBudget = $dap["total_annual_pro_budget"];
            $computeGadAttributedProBudget = 0;
            $HgdgMessage = null;
            $HgdgWrongSign = "";
            
            if((float)$varHgdg < 4) // 0%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if((float)$varHgdg >= 4 && (float)$varHgdg <= 7.99) // 25%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.25);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if((float)$varHgdg >= 8 && (float)$varHgdg <= 14.99) // 50%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.50);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
            }
            else if((float)$varHgdg >= 15 && (float)$varHgdg <= 19.99) // 75%
            { 
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.75);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                
            }
            else if((float)$varHgdg == 20) // 100%
            {
                $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 1);
                $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
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
        $recTotalGadBudget = !empty($qryRecord['total_gad_budget']) ? $qryRecord['total_gad_budget'] : 0;
        $recTotalLguBudget = !empty($qryRecord['total_lgu_budget']) ? $qryRecord['total_lgu_budget'] : 0;
        $fivePercentTotalLguBudget = ($recTotalLguBudget * 0.05);

        if(Tools::GetPlanTypeCodeByRuc($ruc) == 1) // new plan
        {
            $recTotalLguBudget = !empty($qryRecord['total_lgu_budget']) ? $qryRecord['total_lgu_budget'] : 0;
            $fivePercentTotalLguBudget = ($recTotalLguBudget * 0.05);
        }
        else
        {
            if(Tools::GetPlanTypeCodeByRuc($ruc) == 2) // supplemental
            {
                if(Tools::GetHasAdditionalLguBudgetByRuc($ruc) == "yes")
                { // if yes get the current total lgu budget based on current RUC
                    $recTotalLguBudget = !empty($qryRecord['total_lgu_budget']) ? $qryRecord['total_lgu_budget'] : 0;
                    $fivePercentTotalLguBudget = ($recTotalLguBudget * 0.05);
                }
                else
                {
                    if(Tools::GetHasAdditionalLguBudgetByRuc($ruc) == "no")
                    { // if no get the original LGU budget based on the supplemental ID
                        $fivePercentTotalLguBudget = (Tools::GetLguBudgetById(Tools::GetSupplementalIdByRuc($ruc)) * 0.05);
                        $recTotalLguBudget = Tools::GetLguBudgetById(Tools::GetSupplementalIdByRuc($ruc));
                    }
                    else
                    {

                    }
                }
            }
            else // for revision
            {
                $fivePercentTotalLguBudget = Tools::GetLguBudgetById(Tools::GetSupplementalIdByRuc($ruc));
                $recTotalLguBudget = Tools::GetLguBudgetById(Tools::GetRevisionIdByRuc($ruc));
            }
        }

        

        $dataPlanBudget = $searchModel->search(Yii::$app->request->queryParams);
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

        if(Tools::GetPlanTypeCodeByRuc($ruc) ==  1) // new plan
        {
            $grand_total_pb = ($sum_db_budget + $varTotalGadAttributedProBudget);
        }
        else
        {
            if(Tools::GetPlanTypeCodeByRuc($ruc) == 2) // supplemental
            {
                if(Tools::GetHasAdditionalLguBudgetByRuc($ruc) == "yes")
                { // if yes get the current total GAD budget based on current RUC
                    $grand_total_pb = ($sum_db_budget + $varTotalGadAttributedProBudget);
                }
                else
                {
                    if(Tools::GetHasAdditionalLguBudgetByRuc($ruc) == "no")
                    { // if no get the original GAD budget based on the supplemental ID
                       $grand_total_pb = GadPlanBudgetController::GetGadBudgetByRuc(Tools::GetRucById(Tools::GetSupplementalIdByRuc($ruc)));
                    }
                    else
                    {

                    }
                }
            }
            else // for revision
            {
                $grand_total_pb = GadPlanBudgetController::GetGadBudgetByRuc(Tools::GetRucById(Tools::GetRevisionIdByRuc($ruc)));
            }
        }

        

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
        $select_Checklist = ArrayHelper::map(\common\models\GadChecklist::find()->where(['report_type_id' => 1])->all(), 'id', 'title');

        $reportStatus = 0;
        // print_r($ruc); exit;
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
            'upload' => $upload,
            'folder_type' => $folder_type,
            'select_Checklist' => $select_Checklist,
        ]);
    }
    

    /**
     * Displays a single GadPlanBudget model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($row_id,$model_name,$ruc,$onstep,$tocreate,$file_cat)
    {
        $qry = (new \yii\db\Query())
        ->select([
            'FT.title as folder_title',
            'FA.hash',
            'FA.model_name',
            'FA.model_id',
            'FA.file_name',
            'FA.extension',
            'FT.id as folder_id',
            'FA.remarks',
            'FA.user_id'
        ])
        ->from('gad_file_attached FA')
        ->leftJoin(['FT' => 'gad_file_folder_type'], 'FT.id = FA.file_folder_type_id')
        ->groupBy(['FA.file_folder_type_id','FA.id'])
        ->orderBy(['FA.file_folder_type_id' => SORT_ASC,'FA.id' => SORT_ASC])
        ->where(['FA.model_id' => $row_id, 'FA.model_name' => $model_name])
        ->andWhere(['FA.file_folder_type_id' => $file_cat])
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

    public function actionViewOtherDetailsPlan($model_id,$ruc,$onstep,$tocreate)
    {
        $model = GadPlanBudget::find()->where(['record_tuc' => $ruc,'id' => $model_id])->all();

        $modelUpdate = $this->findModel($model_id);
        $tags_ppaSectors = ArrayHelper::map(\common\models\GadPpaAttributedProgram::find()->all(), 'id', 'title');
        $tags_activityCategory = ArrayHelper::map(\common\models\GadActivityCategory::find()->all(), 'id', 'title');

        $opt_focused = ArrayHelper::map(\common\models\GadFocused::find()->all(), 'id', 'title');
        $gender_issue = ArrayHelper::map(\common\models\GadInnerCategory::find()->all(), 'id', 'title');

        $modelUpdate->cliorg_ppa_attributed_program_id = explode(",",$modelUpdate->cliorg_ppa_attributed_program_id);
        $modelUpdate->activity_category_id = explode(",",$modelUpdate->activity_category_id);

        if ($modelUpdate->load(Yii::$app->request->post())) {
            $modelUpdate->cliorg_ppa_attributed_program_id = implode(",",$modelUpdate->cliorg_ppa_attributed_program_id);
            $modelUpdate->activity_category_id = implode(",",$modelUpdate->activity_category_id);
            if($modelUpdate->save(false))
            {
                return $this->redirect(['index','ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate]);
            }
        }

        // print_r($ruc); exit;
        return $this->renderAjax('_view_other_details_plan',[
            'model' => $model,
            'modelUpdate' => $modelUpdate,
            'tags_ppaSectors' => $tags_ppaSectors,
            'tags_activityCategory' => $tags_activityCategory,
            'status' => Tools::GetStatusByRuc($ruc),
            'opt_focused' => $opt_focused,
            'gender_issue' => $gender_issue,
        ]);
    }

    public function actionViewOtherDetailsAttributed($model_id,$ruc,$onstep,$tocreate)
    {
        $model = GadAttributedProgram::find()->where(['record_tuc' => $ruc,'id' => $model_id])->all();

        $modelUpdate = $this->findModelAttributed($model_id);
        $tags_ppaSectors = ArrayHelper::map(\common\models\GadPpaAttributedProgram::find()->all(), 'id', 'title');
        $tags_checkList = ArrayHelper::map(\common\models\GadChecklist::find()->where(['report_type_id' => 1])->all(), 'id', 'title');

        $modelUpdate->ppa_attributed_program_id = explode(",",$modelUpdate->ppa_attributed_program_id);

        if ($modelUpdate->load(Yii::$app->request->post())) {
            $modelUpdate->ppa_attributed_program_id = implode(",",$modelUpdate->ppa_attributed_program_id);
            if($modelUpdate->save(false))
            {
                return $this->redirect(['index','ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate]);
            }
        }

        return $this->renderAjax('_view_other_details_attributed',[
            'model' => $model,
            'modelUpdate' => $modelUpdate,
            'tags_ppaSectors' => $tags_ppaSectors,
            'tags_checkList' => $tags_checkList,
            'status' => Tools::GetStatusByRuc($ruc)
        ]);
    }

    public function actionSearchPlan($ruc,$onstep,$tocreate)
    {
        $model = new GadPlanBudgetSearch();
        $select_GadFocused = ArrayHelper::map(\common\models\GadFocused::find()->all(), 'id', 'title');
        $select_gadMandateGenderIssue = ArrayHelper::map(\common\models\GadInnerCategory::find()->all(), 'id', 'title');
        return $this->renderAjax('_search', [
            'model' => $model,
            'select_GadFocused' => $select_GadFocused,
            'ruc' => $ruc,
            'tocreate' => $tocreate,
            'onstep' => $onstep,
            'select_gadMandateGenderIssue' => $select_gadMandateGenderIssue,
        ]);
    }

    public function actionDeleteUploadedFile($hash,$extension,$ruc,$tocreate,$onstep)
    {
        $hash_name = $hash.".".$extension;
        unlink(Yii::getAlias('@webroot')."/uploads/file_attached/".$hash_name);
        // $qry = GadFileAttached::find()->where(['hash' => $hash])->one();
        // $qry->delete();
        GadFileAttached::deleteAll(['hash' => $hash]);

        $link = "";
        if(Tools::GetReportAcronym($ruc) == "GPB")
        {
            $link = "gad-plan-budget/index";
        }
        else
        {
            $link = "gad-accomplishment-report/index";
        }

        return $this->redirect([$link,'ruc' => $ruc,'onstep' => $onstep,'tocreate' => $tocreate]);
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

    public function actionUploadFormEndorsementFile($ruc,$onstep,$tocreate){
       $upload = new GadFileAttached();
       $folder_type = ArrayHelper::map(\common\models\GadFileFolderType::find()->where(['id' => 3])->all(), 'id', 'title');
       $record = GadRecord::find()->where(['tuc' => $ruc])->one();
       $upload->file_folder_type_id = 3;
       if($upload->load(Yii::$app->request->post()))
       {
            $last_id = $record->id;
            $upload->file_name = UploadedFile::getInstances($upload,'file_name');
            if($upload->file_name)
            {
                $basepath = Yii::getAlias('@app');
                $imagepath= $basepath.'/web/uploads/file_attached/';
                
                $countLoop = 0;
                foreach ($upload->file_name as $image) {
                    $modelName = "GadRecord";
                    $countLoop += 1;
                    $model = new GadFileAttached();
                    $model->user_id = Yii::$app->user->identity->id;
                    $model->remarks = $upload->remarks;
                    $rand_name=rand(10,100);
                    $model->file_name = $image;
                    $model->model_id = $last_id;
                    $model->model_name = $modelName;
                    $miliseconds = round(microtime(true) * 1000);
                    $hash =  md5(date('Y-m-d')."-".date("h-i-sa")."-".$miliseconds.$rand_name.$countLoop.$modelName.$last_id);
                    $model->hash = $hash; 
                    $model->extension = $image->extension;
                    $model->file_folder_type_id = $upload->file_folder_type_id;


                    if($model->save(false))
                    {
                        $image->saveAs($imagepath.$hash.".".$image->extension);
                    }
                }
                
                return $this->redirect(['index','ruc' => $ruc,'onstep' => $onstep,'tocreate' => $tocreate]);
            }
       }

       $qry = (new \yii\db\Query())
        ->select([
            'FT.title as folder_title',
            'FA.hash',
            'FA.model_name',
            'FA.model_id',
            'FA.file_name',
            'FA.extension',
            'FT.id as folder_id',
            'FA.user_id',
            'FA.remarks'
        ])
        ->from('gad_file_attached FA')
        ->leftJoin(['FT' => 'gad_file_folder_type'], 'FT.id = FA.file_folder_type_id')
        ->groupBy(['FA.file_folder_type_id','FA.id'])
        ->orderBy(['FA.file_folder_type_id' => SORT_ASC,'FA.id' => SORT_ASC])
        ->where(['FA.model_id' => $record->id, 'FA.model_name' => 'GadRecord'])
        ->all();
        
       return $this->renderAjax('_upload_form_endorsement',[
            'upload'=>$upload,
            'folder_type' => $folder_type,
            'qry' => $qry,
            'ruc' => $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate
        ]); 
    }

    public function actionUpdateUploadStatusAttributedProgram($ruc,$onstep,$tocreate)
    {
        $attributed = GadAttributedProgram::find()->where(['record_tuc' => $ruc])->orderBy(['id' => SORT_DESC])->one();

        $last_id = $attributed->id;
        GadAttributedProgram::updateAll(['upload_status' => 1],'id = '.$last_id.' ');

        return $this->redirect(['index','ruc' => $ruc,'onstep' => $onstep,'tocreate' => $tocreate]);
    }

    public function actionUpdateUploadFormAttributedProgram($id,$ruc,$onstep,$tocreate,$file_cat,$model_name){
       $upload = new GadFileAttached();
       $folder_type = ArrayHelper::map(\common\models\GadFileFolderType::find()->all(), 'id', 'title');
       $attributed = GadAttributedProgram::find()->where(['record_tuc' => $ruc])->orderBy(['id' => SORT_DESC])->one();

       if($upload->load(Yii::$app->request->post()))
       {
            $upload->file_name = UploadedFile::getInstances($upload,'file_name');
            if($upload->file_name)
            {
                $basepath = Yii::getAlias('@app');
                $imagepath= $basepath.'/web/uploads/file_attached/';
                
                $countLoop = 0;
                foreach ($upload->file_name as $image) {
                    $modelName = $model_name;
                    $countLoop += 1;
                    $model = new GadFileAttached();
                    $model->user_id = Yii::$app->user->identity->id;
                    $model->remarks = $upload->remarks;
                    $rand_name=rand(10,100);
                    $model->file_name = $image;
                    $model->model_id = $id;
                    $model->model_name = $modelName;
                    $miliseconds = round(microtime(true) * 1000);
                    $hash =  md5(date('Y-m-d')."-".date("h-i-sa")."-".$miliseconds.$rand_name.$countLoop.$modelName.$id);
                    $model->hash = $hash; 
                    $model->extension = $image->extension;
                    $model->file_folder_type_id = $file_cat;


                    if($model->save(false))
                    {
                        $image->saveAs($imagepath.$hash.".".$image->extension);
                    }
                }
                $qry = GadAttributedProgram::updateAll(['upload_status' => 2],'id = '.$id.' ');
                
                if($model_name == "GadAttributedProgram")
                {
                    return $this->redirect(['/report/gad-plan-budget/index','ruc' => $ruc,'onstep' => $onstep,'tocreate' => $tocreate]);
                }
                else
                {
                    return $this->redirect(['/report/gad-accomplishment-report/index','ruc' => $ruc,'onstep' => $onstep,'tocreate' => $tocreate]);
                }
                
            }
       }
        
       return $this->renderAjax('_upload_form_attributed_program',[
            'upload'=>$upload,
            'folder_type' => $folder_type,
            'file_cat' => $file_cat
        ]);
    }

    public function actionUploadFormAttributedProgram($ruc,$onstep,$tocreate){
       $upload = new GadFileAttached();
       $folder_type = ArrayHelper::map(\common\models\GadFileFolderType::find()->all(), 'id', 'title');
       $attributed = GadAttributedProgram::find()->where(['record_tuc' => $ruc])->orderBy(['id' => SORT_DESC])->one();

       if($upload->load(Yii::$app->request->post()))
       {
            $last_id = $attributed->id;
            $upload->file_name = UploadedFile::getInstances($upload,'file_name');
            if($upload->file_name)
            {
                $basepath = Yii::getAlias('@app');
                $imagepath= $basepath.'/web/uploads/file_attached/';
                
                $countLoop = 0;
                foreach ($upload->file_name as $image) {
                    $modelName = "GadAttributedProgram";
                    $countLoop += 1;
                    $model = new GadFileAttached();
                    $rand_name=rand(10,100);
                    $model->file_name = $image;
                    $model->model_id = $last_id;
                    $model->model_name = $modelName;
                    $miliseconds = round(microtime(true) * 1000);
                    $hash =  md5(date('Y-m-d')."-".date("h-i-sa")."-".$miliseconds.$rand_name.$countLoop.$modelName.$last_id);
                    $model->hash = $hash; 
                    $model->extension = $image->extension;
                    $model->file_folder_type_id = $upload->file_folder_type_id;
                    $model->user_id = Yii::$app->user->identity->id;
                    $model->remarks = $upload->remarks;


                    if($model->save(false))
                    {
                        $image->saveAs($imagepath.$hash.".".$image->extension);
                    }
                }
                $qry = GadAttributedProgram::updateAll(['upload_status' => 2],'id = '.$last_id.' ');
                return $this->redirect(['index','ruc' => $ruc,'onstep' => $onstep,'tocreate' => $tocreate]);
            }
       }
        
       return $this->renderAjax('_upload_form_attributed_program',[
            'upload'=>$upload,
            'folder_type' => $folder_type,
        ]);
    }

    
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
                        $model->user_id = Yii::$app->user->identity->id;
                        $rand_name=rand(10,100);
                        $model->file_name = $image;
                        $model->model_id = $id;
                        $model->model_name = $modelName;
                        $miliseconds = round(microtime(true) * 1000);
                        $hash =  md5(date('Y-m-d')."-".date("h-i-sa")."-".$miliseconds.$rand_name.$countLoop.$modelName.$id);
                        $model->hash = $hash; 
                        $model->extension = $image->extension;
                        $model->file_folder_type_id = $upload->file_folder_type_id;
                        $model->remarks = $upload->remarks;

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

    /**
     * Finds the GadPlanBudget model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GadPlanBudget the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelAttributed($id)
    {
        if (($model = GadAttributedProgram::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
