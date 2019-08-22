<?php

namespace common\modules\report\controllers;

use Yii;
use common\models\GadAccomplishmentReport;
use common\models\GadPlanBudget;
use common\models\GadArAttributedProgram;
use common\models\GadAttributedProgram;
use common\modules\report\controllers\DefaultController;
use common\modules\report\models\GadAccomplishmentReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GadRecord;
use yii\helpers\ArrayHelper;
use yii\db\Query;

/**
 * GadAccomplishmentReportController implements the CRUD actions for GadAccomplishmentReport model.
 */
class GadAccomplishmentReportController extends Controller
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

    public function actionCopyInsertPlan($ruc,$onstep,$tocreate,$selected_plan_ruc)
    {
        $query = GadPlanBudget::find()->where(['record_tuc' => $selected_plan_ruc])->groupBy(['id'])->all();

        foreach ($query as $key => $plan) {
            $ar = new GadAccomplishmentReport();
            $ar->plan_budget_id = $plan['id'];
            $ar->record_id = DefaultController::GetRecordIdByRuc($ruc);
            $ar->focused_id = $plan['focused_id'];
            $ar->inner_category_id = $plan['inner_category_id'];
            $ar->gi_sup_data = $plan['gi_sup_data'];
            $ar->source = $plan['source'];
            $ar->cliorg_ppa_attributed_program_id = $plan['cliorg_ppa_attributed_program_id'];
            $ar->ppa_value = $plan['ppa_value'];
            $ar->objective = $plan['objective'];
            $ar->relevant_lgu_ppa = $plan['relevant_lgu_program_project'];
            $ar->activity_category_id = $plan['activity_category_id'];
            $ar->activity = $plan['activity'];
            $ar->performance_indicator = $plan['performance_target'];
            $gad_budget = ($plan['budget_mooe'] + $plan['budget_ps'] + $plan['budget_co']);
            $ar->total_approved_gad_budget = $gad_budget;
            $ar->record_tuc = $ruc;
            $ar->save(false);
        }

        $attribQuery = GadAttributedProgram::find()->where(['record_tuc' => $selected_plan_ruc])->groupBy(['id'])->all();

        foreach ($attribQuery as $key2 => $attrib) {
            $ar_attrib = new GadArAttributedProgram();
            $ar_attrib->record_tuc = $ruc;
            $ar_attrib->controller_id = "gad-accomplishment-report";
            $ar_attrib->ppa_attributed_program_id = $attrib['ppa_attributed_program_id'];
            $ar_attrib->lgu_program_project = $attrib['lgu_program_project'];
            $ar_attrib->checklist_id = $attrib['checklist_id'];
            $ar_attrib->hgdg_pimme = $attrib['hgdg'];
            $ar_attrib->total_annual_pro_cost = $attrib['total_annual_pro_budget'];
            $ar_attrib->save(false);

        }

        return $this->redirect(['index','ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate]);
    }

    public function actionCopyPlan($ruc,$onstep,$tocreate)
    {
        $filter = [];
        if(Yii::$app->user->can('gad_lgu_permission'))
        {
            $filter = ['GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C, 'GR.citymun_c' => Yii::$app->user->identity->userinfo->CITYMUN_C];
        }
        else if(Yii::$app->user->can('gad_lgu_province_permission'))
        {
            $filter = ['GR.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C];
        }

        $query = (new Query())
        ->select([
            'PROV.province_m',
            'CTY.citymun_m',
            'GR.id as record_id',
            'GR.tuc as ruc',
            'GR.total_lgu_budget',
            'GR.year',
            'GR.prepared_by',
            'GR.approved_by',
            'GR.footer_date',
            'GR.status'
        ])
        ->from('gad_record GR')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = GR.region_c')
        ->leftJoin(['PROV' => 'tblprovince'], 'PROV.province_c = GR.province_c')
        ->leftJoin(['CTY' => 'tblcitymun'], 'CTY.citymun_c = GR.citymun_c and CTY.province_c = GR.province_c')
        ->leftJoin(['OFC' => 'tbloffice'], 'OFC.OFFICE_C = GR.office_c')
        ->andWhere(['GR.report_type_id' => 1])
        ->andFilterWhere($filter)
        ->groupBy(['GR.id'])
        ->orderBy(['GR.id' => SORT_DESC])
        ->all();

        return $this->renderAjax('_copy_plan', [
            'query' => $query,
            'ruc' => $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate
        ]);
    }

    public function actionViewOtherDetailsAttributed($model_id,$ruc,$onstep,$tocreate)
    {
        $model = GadArAttributedProgram::find()->where(['record_tuc' => $ruc,'id' => $model_id])->all();

        $modelUpdate = $this->findModelAttributed($model_id);
        $tags_ppaSectors = ArrayHelper::map(\common\models\GadPpaAttributedProgram::find()->all(), 'id', 'title');
        $tags_checkList = ArrayHelper::map(\common\models\GadChecklist::find()->where(['report_type_id' => 2])->all(), 'id', 'title');
        $select_scoreType = ArrayHelper::map(\common\models\GadScoreType::find()->all(), 'code', 'title');

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
            'select_scoreType' => $select_scoreType,
            'status' => DefaultController::GetStatusByRuc($ruc),
        ]);
    }

    public function actionViewOtherDetails($model_id,$ruc,$onstep,$tocreate)
    {
        $model = GadAccomplishmentReport::find()->where(['record_tuc' => $ruc,'id' => $model_id])->all();

        $modelUpdate = $this->findModel($model_id);
        $tags_ppaSectors = ArrayHelper::map(\common\models\GadPpaAttributedProgram::find()->all(), 'id', 'title');
        $tags_activityCategory = ArrayHelper::map(\common\models\GadActivityCategory::find()->all(), 'id', 'title');

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

        return $this->renderAjax('_view_other_details_accomplishment',[
            'model' => $model,
            'modelUpdate' => $modelUpdate,
            'tags_ppaSectors' => $tags_ppaSectors,
            'tags_activityCategory' => $tags_activityCategory,
            'status' => DefaultController::GetStatusByRuc($ruc)
        ]);
    }

    public function ComputeAccomplishment($ruc)
    {
        $grand_total_ar = 0;
        $dataAttributedProgram = (new \yii\db\Query())
        ->select([
            'AP.id',
            // 'IF(AP.ppa_attributed_program_id = 0, AP.ppa_attributed_program_others, PAP.title) as ap_ppa_value',
            'AP.lgu_program_project',
            'AP.hgdg_pimme',
            'AP.total_annual_pro_cost',
            'AP.gad_attributed_pro_cost',
            'AP.ar_ap_variance_remarks',
            'AP.record_tuc',
            'AP.controller_id'
        ])
        ->from('gad_ar_attributed_program AP')
        ->leftJoin(['PAP' => 'gad_ppa_attributed_program'], 'PAP.id = AP.ppa_attributed_program_id')
        ->where(['AP.record_tuc' => $ruc])
        ->groupBy(['AP.lgu_program_project','AP.id'])
        ->orderBy(['AP.id' => SORT_ASC,'AP.lgu_program_project' => SORT_ASC])
        ->all();

        $varTotalGadAttributedProBudget = 0;
        foreach ($dataAttributedProgram as $key => $dap) {
            // $sum_ap_apc += $dap['gad_attributed_pro_cost'];
            $varHgdg = $dap["hgdg_pimme"];
            $varTotalAnnualProCost = $dap["total_annual_pro_cost"];
            $computeGadAttributedProCost = 0;
            $HgdgMessage = null;
            $HgdgWrongSign = "";
            
            if((float)$varHgdg < 4) // 0%
            {
                // echo "GAD is invisible";
                $computeGadAttributedProCost = ($varTotalAnnualProCost * 0);
                $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
            }
            else if((float)$varHgdg >= 4 && (float)$varHgdg <= 7.99) // 25%
            {
                // echo "Promising GAD prospects (conditional pass)";
                $computeGadAttributedProCost = ($varTotalAnnualProCost * 0.25);
                $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
            }
            else if((float)$varHgdg >= 8 && (float)$varHgdg <= 14.99) // 50%
            {
                // echo "Gender Sensetive";
                $computeGadAttributedProCost = ($varTotalAnnualProCost * 0.50);
                $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
            }
            else if((float)$varHgdg >= 15 && (float)$varHgdg <= 19.99) // 75%
            {
                // echo "Gender-responsive";
                $computeGadAttributedProCost = ($varTotalAnnualProCost * 0.75);
                $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
            }
            else if((float)$varHgdg == 20) // 100%
            {
                // echo "Full gender-resposive";
                $computeGadAttributedProCost = ($varTotalAnnualProCost * 1);
                $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
            }
            else
            {
                $HgdgMessage = "Unable to compute (undefined HGDG Score).";
                $HgdgWrongSign = "<span class='glyphicon glyphicon-alert' style='color:red;' title='Not HGDG Score Standard'></span>";
            }
        }

        $dataAR = (new \yii\db\Query())
        ->select([
            'AR.id',
            // 'IF(AR.ppa_focused_id = 0, AR.ppa_value,CF.title) as ppa_value',
            'AR.ppa_value',
            'AR.cause_gender_issue',
            'AR.objective',
            'AR.relevant_lgu_ppa',
            'AR.activity',
            'AR.performance_indicator',
            'AR.target',
            'AR.actual_results',
            'AR.total_approved_gad_budget',
            'AR.actual_cost_expenditure',
            'AR.variance_remarks',
            'AR.record_tuc',
            'GF.title as gad_focused_title',
            'IC.title as inner_category_title',
            'GC.id as gad_focused_id',
            'IC.id as inner_category_id',
            'AR.focused_id',
            'REC.status as record_status'
        ])
        ->from('gad_accomplishment_report AR')
        // ->leftJoin(['CF' => 'gad_ppa_client_focused'], 'CF.id = AR.ppa_focused_id')
        ->leftJoin(['GC' => 'gad_comment'], 'GC.plan_budget_id = AR.id')
        ->leftJoin(['GF' => 'gad_focused'], 'GF.id = AR.focused_id')
        ->leftJoin(['IC' => 'gad_inner_category'], 'IC.id = AR.inner_category_id')
        ->leftJoin(['REC' => 'gad_record'], 'REC.id = AR.record_id')
        ->where(['AR.record_tuc' => $ruc])
        ->orderBy(['AR.focused_id' => SORT_ASC,'AR.inner_category_id' => SORT_ASC,'AR.ppa_value' => SORT_ASC,'AR.id' => SORT_ASC])
        ->groupBy(['AR.focused_id','AR.inner_category_id','AR.ppa_value','AR.cause_gender_issue','AR.objective','AR.relevant_lgu_ppa','AR.activity','AR.performance_indicator','AR.target','AR.actual_results','AR.id'])
        ->all();

        $sum_ar_ace = 0;
        foreach ($dataAR as $key => $dr) {
            $sum_ar_ace += $dr["actual_cost_expenditure"]; // cliorg table
        }

        $grand_total_ar = ($sum_ar_ace + $varTotalGadAttributedProBudget);

        $qryRecord = GadRecord::find()->where(['tuc' => $ruc])->one();
        $recTotalLguBudget = $qryRecord->total_lgu_budget;

        $fivePercentTotalLguBudget = ($recTotalLguBudget * 0.05);

        if($grand_total_ar < $fivePercentTotalLguBudget)
        {
            return "<span style='color:red;'>  Php ".number_format($grand_total_ar,2)."</span>";
        }
        else
        {
            return "<span style='color:blue;'>  Php ".number_format($grand_total_ar,2)."</span>";
        }
    }

    /**
     * Lists all GadAccomplishmentReport models.
     * @return mixed
     */
    public function actionIndex($ruc,$onstep,$tocreate)
    {
        Yii::$app->session["activelink"] = $tocreate;
        $grand_total_ar = 0;
        $dataRecord = GadRecord::find()->where(['tuc' => $ruc, 'report_type_id' => 2])->all();
        Yii::$app->session["session_arDataRecord"] = $dataRecord;
        $dataAttributedProgram = (new \yii\db\Query())
        ->select([
            'AP.id',
            // 'IF(AP.ppa_attributed_program_id = 0, AP.ppa_attributed_program_others, PAP.title) as ap_ppa_value',
            'AP.lgu_program_project',
            'AP.hgdg_pimme',
            'AP.total_annual_pro_cost',
            'AP.gad_attributed_pro_cost',
            'AP.ar_ap_variance_remarks',
            'AP.record_tuc',
            'AP.controller_id',
            'REC.status as record_status'
        ])
        ->from('gad_ar_attributed_program AP')
        ->leftJoin(['PAP' => 'gad_ppa_attributed_program'], 'PAP.id = AP.ppa_attributed_program_id')
        ->leftJoin(['REC' => 'gad_record'], 'REC.tuc = AP.record_tuc')
        ->where(['AP.record_tuc' => $ruc])
        ->groupBy(['AP.lgu_program_project','AP.id'])
        ->orderBy(['AP.id' => SORT_ASC,'AP.lgu_program_project' => SORT_ASC])
        ->all();
        Yii::$app->session['session_arDataAttributedProgram'] = $dataAttributedProgram;

        $sum_ap_apc = 0;
        $varTotalGadAttributedProBudget = 0;
        foreach ($dataAttributedProgram as $key => $dap) {
            $sum_ap_apc += $dap['gad_attributed_pro_cost'];
            $varHgdg = $dap["hgdg_pimme"];
            $varTotalAnnualProCost = $dap["total_annual_pro_cost"];
            $computeGadAttributedProCost = 0;
            $HgdgMessage = null;
            $HgdgWrongSign = "";
            
            if($varHgdg < 4) // 0%
            {
                // echo "GAD is invisible";
                $computeGadAttributedProCost = ($varTotalAnnualProCost * 0);
                $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
            }
            else if($varHgdg >= 4 && $varHgdg <= 7.9) // 25%
            {
                // echo "Promising GAD prospects (conditional pass)";
                $computeGadAttributedProCost = ($varTotalAnnualProCost * 0.25);
                $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
            }
            else if($varHgdg >= 8 && $varHgdg <= 14.9) // 50%
            {
                // echo "Gender Sensetive";
                $computeGadAttributedProCost = ($varTotalAnnualProCost * 0.50);
                $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
            }
            else if($varHgdg >= 15 && $varHgdg <= 19.9) // 75%
            {
                // echo "Gender-responsive";
                $computeGadAttributedProCost = ($varTotalAnnualProCost * 0.75);
                $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
            }
            else if($varHgdg == 20) // 100%
            {
                // echo "Full gender-resposive";
                $computeGadAttributedProCost = ($varTotalAnnualProCost * 1);
                $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
            }
            else
            {
                $HgdgMessage = "Unable to compute (undefined HGDG Score).";
                $HgdgWrongSign = "<span class='glyphicon glyphicon-alert' style='color:red;' title='Not HGDG Score Standard'></span>";
            }
        }
        // print_r($grand_total_ar); exit;


        $qryRecord = (new \yii\db\Query())
        ->select([
            'REG.region_m as region_name',
            'PRV.province_m as province_name',
            'CTC.citymun_m as citymun_name',
            'GR.total_lgu_budget',
            'GR.total_gad_budget'
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
        $recTotalLguBudget = !empty($qryRecord['total_lgu_budget']) ? $qryRecord['total_lgu_budget'] : "";
        $recTotalGadBudget = !empty($qryRecord['total_gad_budget']) ? $qryRecord['total_gad_budget'] : "";

        

        $fivePercentTotalLguBudget = ($recTotalLguBudget * 0.05);

        $dataAR = (new \yii\db\Query())
        ->select([
            'AR.id',
            // 'IF(AR.ppa_focused_id = 0, AR.ppa_value,CF.title) as ppa_value',
            'AR.ppa_value',
            'AR.cause_gender_issue',
            'AR.objective',
            'AR.relevant_lgu_ppa',
            'AR.activity',
            'AR.performance_indicator',
            'AR.target',
            'AR.actual_results',
            'AR.total_approved_gad_budget',
            'AR.actual_cost_expenditure',
            'AR.variance_remarks',
            'AR.record_tuc',
            'GF.title as gad_focused_title',
            'IC.title as inner_category_title',
            'GC.id as gad_focused_id',
            'IC.id as inner_category_id',
            'AR.focused_id',
            'REC.status as record_status',
            'AR.source as source_value',
            'AR.gi_sup_data as sup_data'
        ])
        ->from('gad_accomplishment_report AR')
        // ->leftJoin(['CF' => 'gad_ppa_client_focused'], 'CF.id = AR.ppa_focused_id')
        ->leftJoin(['GC' => 'gad_comment'], 'GC.plan_budget_id = AR.id')
        ->leftJoin(['GF' => 'gad_focused'], 'GF.id = AR.focused_id')
        ->leftJoin(['IC' => 'gad_inner_category'], 'IC.id = AR.inner_category_id')
        ->leftJoin(['REC' => 'gad_record'], 'REC.id = AR.record_id')
        ->where(['AR.record_tuc' => $ruc])
        ->orderBy(['AR.focused_id' => SORT_ASC,'AR.inner_category_id' => SORT_ASC,'AR.ppa_value' => SORT_ASC,'AR.id' => SORT_ASC])
        ->groupBy(['AR.focused_id','AR.inner_category_id','AR.ppa_value','AR.cause_gender_issue','AR.objective','AR.relevant_lgu_ppa','AR.activity','AR.performance_indicator','AR.target','AR.actual_results','AR.id'])
        ->all();

        Yii::$app->session["session_arDataAccomplishment"] = $dataAR;
        // ->createCommand()->rawSql;
        // echo "<pre>";
        // print_r($dataAR); exit;

        $sum_ar_ace = 0;
        foreach ($dataAR as $key => $dr) {
            $sum_ar_ace += $dr["actual_cost_expenditure"]; // cliorg table
        }

        $grand_total_ar = ($sum_ar_ace + $varTotalGadAttributedProBudget);

        $select_GadFocused = ArrayHelper::map(\common\models\GadFocused::find()->all(), 'id', 'title');
        $select_GadInnerCategory = ArrayHelper::map(\common\models\GadInnerCategory::find()->all(), 'id', 'title');
        $select_PpaAttributedProgram = ArrayHelper::map(\common\models\GadPpaAttributedProgram::find()->all(), 'id', 'title');
        $select_ActivityCategory = ArrayHelper::map(\common\models\GadActivityCategory::find()->all(), 'id', 'title');
        $select_Checklist = ArrayHelper::map(\common\models\GadChecklist::find()->where(['report_type_id' => 2])->all(), 'id', 'title');
        $select_scoreType = ArrayHelper::map(\common\models\GadScoreType::find()->all(), 'code', 'title');
        $reportStatus = 0;
        $modelRecord = GadRecord::find()->where(['tuc' => $ruc])->one();
        $qryReportStatus = $modelRecord->status;

        $render_index = "";
        if($onstep == "to_create_ar")
        {
            $render_index = "step_form";
        }
        else
        {
            // Yii::$app->session["encode_gender_ar"] = "closed";
            // Yii::$app->session["encode_attribute_ar"] = "closed";
            $render_index = "index";
        }

        return $this->render($render_index, [
            'select_GadFocused' => $select_GadFocused,
            'select_GadInnerCategory' => $select_GadInnerCategory,
            'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
            'dataRecord' => $dataRecord,
            'dataAR' => $dataAR,
            'recRegion' => $recRegion,
            'recProvince' => $recProvince,
            'recCitymun' => $recCitymun,
            'recTotalGadBudget' => $recTotalGadBudget,
            'recTotalLguBudget' => $recTotalLguBudget,
            'ruc' => $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate,
            'dataAttributedProgram' => $dataAttributedProgram,
            'grand_total_ar' => $grand_total_ar,
            'fivePercentTotalLguBudget' => $fivePercentTotalLguBudget,
            'qryReportStatus' => $qryReportStatus,
            'select_ActivityCategory' => $select_ActivityCategory,
            'select_Checklist' => $select_Checklist,
            'select_scoreType' => $select_scoreType,
        ]);
    }

    /**
     * Displays a single GadAccomplishmentReport model.
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
     * Creates a new GadAccomplishmentReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GadAccomplishmentReport();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GadAccomplishmentReport model.
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
     * Deletes an existing GadAccomplishmentReport model.
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
     * Finds the GadAccomplishmentReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GadAccomplishmentReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GadAccomplishmentReport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the GadAccomplishmentReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GadAccomplishmentReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelAttributed($id)
    {
        if (($model = GadArAttributedProgram::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
