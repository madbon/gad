<?php

namespace common\modules\report\controllers;

use yii\web\Controller;
use niksko12\user\models\UserInfo;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;
use common\models\GadPlanBudget;
use common\models\GadComment;
use common\models\GadPpaOrganizationalFocused;
use common\models\GadPpaClientFocused;
use common\models\GadInnerCategory;
use common\models\GadAttributedProgram;
use common\models\GadArAttributedProgram;
use common\models\GadRecord;
use common\models\GadAccomplishmentReport;
use common\models\GadReportHistory;
use common\models\GadFocused;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use \common\models\GadFileAttached;
use common\models\CreateStatus;
use common\modules\report\controllers\GadPlanBudgetController;
use common\modules\report\controllers\GadAccomplishmentReportController;
use common\modules\report\controllers\GadRecordController;
use yii\web\UploadedFile;
use niksko12\auditlogs\classes\ControllerAudit;
use yii\helpers\ArrayHelper;
use common\models\GadStatusAssignment;
/**
 * Default controller for the `report` module
 */
class DefaultController extends ControllerAudit
{
    public function GetFocusedTitle($id)
    {
        $qry = GadFocused::find()->where(['id' => $id])->one();

        return !empty($qry->title) ? $qry->title : "";
    }

    public function GetInnerCatTitle($id)
    {
        $qry = GadInnerCategory::find()->where(['id' => $id])->one();
        return !empty($qry->title) ? $qry->title : "";
    }

    public function GetRoleName()
    {
        $arrayRole = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id));

        return !empty($arrayRole[0]) ? $arrayRole[0] : "";
    }

    public function HasAction($param)
    {
        $arrayRole = [];
        $arrayRole = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id));
        $tags_status = GadStatusAssignment::find()
            ->select(['status'])
            ->where(['role' => $param])
            ->andFilterWhere(['rbac_role' => $arrayRole])
            ->one();
        
        return count($tags_status) > 0 ? 1 : 0;
    }

    public function Can($param)
    {
        $arrayRole = [];
        $arrayRole = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id));
        $tags_status = GadStatusAssignment::find()
            ->select(['status'])
            ->where(['role' => $param])
            ->andFilterWhere(['rbac_role' => $arrayRole])
            ->all();
        $array = [];
        foreach ($tags_status as $key => $row) {
            $array[] = $row['status'];
        }

        $string = implode(",",$array);
        $array_val = explode(",",$string);
        
        return $array_val;
    }

    public function HasStatus($param)
    {
        $tags_status = GadStatusAssignment::find()->select(['status'])->where(['role' => $param])->all();
        $array = [];
        foreach ($tags_status as $key => $row) {
            $array[] = $row['status'];
        }

        $string = implode(",",$array);
        $array_val = explode(",",$string);
        
        return $array_val;
    }

    public function ViewStatus($role)
    {
        $tags_status = GadStatusAssignment::find()->select(['status'])->where(['role' => $role])->all();
        $array = [];
        foreach ($tags_status as $key => $row) {
            $array[] = $row['status'];
        }

        return explode(",",$array[0]);
    }

    public function HasBeenAttachedToGpb($ar_ruc)
    {
        if(GadRecord::find()->where(['attached_ar_record_id' => DefaultController::GetRecordIdByRuc($ar_ruc)])->exists())
        {
            $query = GadRecord::find()->where(['attached_ar_record_id' => DefaultController::GetRecordIdByRuc($ar_ruc)])->one();
            $plan_id = !empty($query->id) ? $query->id : "";
            $ruc = !empty($query->tuc) ? $query->tuc : "";
            $year = !empty($query->year) ? $query->year : "";
            $total_lgu_budget = !empty($query->total_lgu_budget) ? $query->total_lgu_budget : "";
            $total_gad_budget = GadPlanBudgetController::ComputeGadBudget($ruc);

            return "<label class='label label-success' style='font-size:15px; font-weight:normal'>Note : This Accomplishment Report has been attached to GAD Plan and Budget <span style='color:blue;'>FY ".$year."</span> with Total LGU Budget of <span style='color:blue;'>Php ".number_format($total_lgu_budget,2)."</span> & Total GAD Budget of ".($total_gad_budget)."</label><br/><br/>";
        }
        else
        {
            return "";
        }
       
    }

    public function ScoreTypeTitle($id)
    {
        $query = \common\models\GadScoreType::find()->select(['title'])->where(['id' => $id])->one();

       
        return !empty($query->title) ? $query->title : "";
    }

    public function ChecklistViewAccomplishment($id)
    {
        $query = \common\models\GadChecklist::find()->select(['title'])->where(['id' => $id])
        ->where(['report_type_id' => 2])->one();

       
        return !empty($query->title) ? $query->title : "";
    }

    public function ChecklistViewPlan($id)
    {
        $query = \common\models\GadChecklist::find()->select(['title'])->where(['id' => $id])
        ->where(['report_type_id' => 1])->one();

       
        return !empty($query->title) ? $query->title : "";
    }

    public function ActivityCategoryIdView($tags)
    {
        $query = \common\models\GadActivityCategory::find()->select(['title'])->where(new Expression('id IN ('.$tags.')'))
        ->all();

        $arr_value = [];
        foreach ($query as $key => $row) {
            $arr_value[] = "<span class='label label-info'>".$row['title']."</span>";
        }

        $tags = implode(", ", $arr_value);
        return $tags;
    }

    public function PpaSectorsTagView($tags)
    {
        $query = \common\models\GadPpaAttributedProgram::find()->select(['title'])->where(new Expression('id IN ('.$tags.')'))
        ->all();

        $arr_value = [];
        foreach ($query as $key => $row) {
            $arr_value[] = "<span class='label label-info'>".$row['title']."</span>";
        }

        $tags = implode(", ", $arr_value);
        return $tags;
    }

    public function actionLoadRecordByStatus($status)
    {
        $andFilterValue = [];
        $station = [];
        if(Yii::$app->user->can("gad_lgu_permission"))
        {
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS")
            {
                $status = 6;
                $andFilterValue = ['REC.office_c' => [3,4]];
                $station = ['REC.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C, 'REC.citymun_c' => Yii::$app->user->identity->userinfo->CITYMUN_C];
            }
        }
        else if(Yii::$app->user->can("gad_lgu_province_permission"))
        {
            $status = 6;
            $andFilterValue = ['REC.office_c' => 2];
            $station = ['REC.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C, 'REC.citymun_c' => null];
        }

        $qry = (new \yii\db\Query())
        ->select([
            'PRV.province_m as province_name',
            'CTC.citymun_m as citymun_name',
            'REC.status as record_status',
            'REC.total_lgu_budget',
            'REC.year',
            'REC.prepared_by',
            'REC.approved_by',
            'REC.id as record_id',
            'ST.title as status_name',
            'REC.tuc as ruc',
            'OF.OFFICE_M as office_name'
        ])
        ->from('gad_record REC')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = REC.region_c')
        ->leftJoin(['PRV' => 'tblprovince'], 'PRV.province_c = REC.province_c')
        ->leftJoin(['CTC' => 'tblcitymun'], 'CTC.citymun_c = REC.citymun_c AND CTC.province_c = REC.province_c')
        ->leftJoin(['ST' => 'gad_status'], 'ST.id = REC.status')
        ->leftJoin(['OF' => 'tbloffice'], 'OF.OFFICE_C = REC.office_c')
        ->where(['REC.status' => $status,'REC.report_type_id' => 1])
        ->andFilterWhere($andFilterValue)
        ->andFilterWhere($station)
        ->all();

        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'record_id' => $item["record_id"],
                        'province_name' => $item["province_name"],
                        'citymun_name' => $item["citymun_name"],
                        'record_status' => $item["record_status"],
                        'total_lgu_budget' => $item["total_lgu_budget"],
                        'prepared_by' => $item["prepared_by"],
                        'approved_by' => $item["approved_by"],
                        'status_name' => $this::DisplayStatus($item["record_status"]),
                        'year' => $item["year"],
                        'ruc' => $item["ruc"],
                        'office_name' => $item["office_name"],
                        'total_gad_budget' => GadPlanBudgetController::ComputeGadBudget($item["ruc"]),
                        'remarks' => GadRecordController::GenerateRemarks($item["ruc"]),
                    ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }

    public function CreatePlanStatusCode($ruc)
    {
        $record = GadRecord::find()->where(['tuc' => $ruc])->one();
        return $record->create_status_id;
    }
    // public function CreatePlanStatus($ruc)
    // {
    //     $record = GadRecord::find()->where(['tuc' => $ruc])->one();
    //     $qry = CreateStatus::find()->where(['code' => $record->create_status_id])->one();
    //     return !empty($qry->title) ? $qry->title : "unknown status";
    // }
    public function PlanUploadStatus($row_id)
    {
        // 0 = no uploaded files
        // 1 = upload later
        // 2 = has an uploaded file
        $qry = GadPlanBudget::find()->select(['upload_status','id'])->where(['id' => $row_id])->one();

        return $qry->upload_status;
    }
    public function GetRecordIdByRuc($ruc)
    {
        $qry = GadRecord::find()->where(['tuc' => $ruc])->one();
        return $qry->id;
    }
    public function CountUploadedFile($ruc,$model_name)
    {
        $record_id = DefaultController::GetRecordIdByRuc($ruc);
        $qry = GadFileAttached::find()->where(['model_id' =>  $record_id,'model_name' => $model_name])->count();
        return $qry;
    }
    public function PlanUploadStatusAttrib($row_id)
    {
        // 0 = no uploaded files
        // 1 = upload later
        // 2 = has an uploaded file
        $qry = GadAttributedProgram::find()->select(['upload_status','id'])->where(['id' => $row_id])->one();

        return $qry->upload_status;
    }

    public function actionUpdateUploadStatus($row_id)
    {
        $qry = GadPlanBudget::updateAll(['upload_status' => 1],'id = '.$row_id.' ');

        return 1;
    }

    public function FileCatName($id)
    {
        $qry = \common\models\GadFileFolderType::find()->where(['id' => $id])->one();

        return !empty($qry->title) ? $qry->title : "";
    }

    public  function GetUploadStatusByFileCat($row_id,$model_name,$file_cat)
    {
        $qry = GadFileAttached::find()->where(['model_id' => $row_id, 'model_name' => $model_name,'file_folder_type_id' => $file_cat]);

        if($qry->exists())
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public  function GetUploadStatus($row_id,$model_name)
    {
        $qry = GadFileAttached::find()->where(['model_id' => $row_id, 'model_name' => $model_name]);

        if($qry->exists())
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function GetOfficeId($ruc)
    {
        $Record = GadRecord::find()->where(['tuc' => $ruc])->one();

        return $Record->office_c;
    }
    public function GetProvinceName($ruc)
    {
        $Record = GadRecord::find()->where(['tuc' => $ruc])->one();
        $Query = Province::find()->where(['province_c' => $Record->province_c])->one();

        return $Query->province_m;
    }
    public function GetRegionName($ruc)
    {
        $Record = GadRecord::find()->where(['tuc' => $ruc])->one();
        $Query = Region::find()->where(['region_c' => $Record->region_c])->one();

        return $Query->region_m;
    }
    public function GetCitymunName($ruc)
    {
        $Record = GadRecord::find()->where(['tuc' => $ruc])->one();

        if($Record->office_c == 3 || $Record->office_c == 4)
        {
            $Query = Citymun::find()->where(['province_c' => $Record->province_c, 'citymun_c' => $Record->citymun_c])->one();
            return $Query->citymun_m;
        }
        else
        {
            return "";
        }
    }

    public function GetReportTitle($ruc)
    {
        $Query = GadRecord::find()->where(['tuc' => $ruc])->one();

        return $Query->report_type_id == 1 ? "Plan and Budget" : "Accomplishment Report";
    }

    public function GetReportAcronym($ruc)
    {
        $Query = GadRecord::find()->where(['tuc' => $ruc])->one();

        return $Query->report_type_id == 1 ? "GPB" : "AR";
    }

    public function GetPlanYear($ruc)
    {
        $Query = GadRecord::find()->where(['tuc' => $ruc])->one();

        return !empty($Query->year) ? $Query->year : "No set Year";
    }

    public function actionDeleteAccomplishmentAttrib($ar_attrib_id)
    {
        if(GadArAttributedProgram::deleteAll(['id'=>$ar_attrib_id]))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public function actionDeleteAccomplishment($ar_id)
    {
        if(GadAccomplishmentReport::deleteAll(['id'=>$ar_id]))
        {
            return 1;
        }
        else
        {
            return 0;
        }
        
    }
    public function actionDeletePlanBudgetAttrib($attrib_id)
    {
        $model = GadAttributedProgram::deleteAll(['id'=>$attrib_id]);

        // \Yii::$app->getSession()->setFlash('success', "Data has been deleted");
        // return $this->redirect(['gad-plan-budget/index','ruc' => $ruc,'onstep'=>$onstep,'tocreate'=>$tocreate]);
    }

    public function GetStatusByRuc($ruc)
    {
        $model = GadRecord::find()->where(['tuc' => $ruc])->one();
        $sam =  $model->status;
        return $sam;
    }

    public function actionDeletePlanBudgetGenderIssue($plan_id)
    {
       if(GadPlanBudget::deleteAll(['id'=>$plan_id]))
       {
            return 1; // success
       }
       else
       {
            return 0; // not
       }
    }

    public  function DisplayStatusWithCode($value)
    {
        $returnValue = "";
        $query  = \common\models\GadStatus::find()->where(['code' => $value])->one();
        $title  = !empty($query->title) ? $query->title : "";
        $class  = !empty($query->class) ? $query->class : '';
        $code   = !empty($query->code) ? $query->code : "";

        $returnValue = "<span class='".($class)."'>".$code." - ".$title."</span>";
        // print_r($class); exit;
        return $returnValue;
    }

    public  function DisplayStatus($value)
    {
        $returnValue = "";
        $query = \common\models\GadStatus::find()->where(['code' => $value])->one();
        $title = !empty($query->title) ? $query->title : "";
        $class = !empty($query->class) ? $query->class : '';

        $returnValue = "<span class='".($class)."'>".$title."</span>";
        // print_r($class); exit;
        return $returnValue;
    }

    public function DisplayStatusByTuc($tuc)
    {
        $qry = GadRecord::find()->where(['tuc' => $tuc])->one();

        return DefaultController::DisplayStatus($qry->status);
    }

    public function actionCreateReportHistory($valueTextRemarks,$valueReportStatus,$tuc,$valueOnStep,$valueToCreate)
    {
        
        date_default_timezone_set("Asia/Manila");
        $model = new GadReportHistory();
        $model->remarks = $valueTextRemarks;
        $model->tuc = $tuc;
        $model->status = $valueReportStatus;
        $model->date_created = date('Y-m-d');
        $model->time_created = date("h:i:sa");
        $model->responsible_user_id = !empty(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : "";
        $model->responsible_region_c = !empty(Yii::$app->user->identity->userinfo->REGION_C) ? Yii::$app->user->identity->userinfo->REGION_C : "";
        $model->responsible_province_c = !empty(Yii::$app->user->identity->userinfo->PROVINCE_C) ? Yii::$app->user->identity->userinfo->PROVINCE_C : "";
        $model->responsible_citymun_c = !empty(Yii::$app->user->identity->userinfo->CITYMUN_C) ? Yii::$app->user->identity->userinfo->CITYMUN_C : "";
        $model->fullname = Yii::$app->user->identity->userinfo->FIRST_M." ".Yii::$app->user->identity->userinfo->LAST_M;


        if(Yii::$app->user->can("gad_lgu_permission"))
        {
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->REGION_C == 13)
            {
                $model->responsible_office_c = 4; // City Office
            }
            else
            {
                $model->responsible_office_c = 3; // Municipal Office
            }
        }
        else if(Yii::$app->user->can("gad_lgu_province_permission"))
        {
            $model->responsible_office_c = 2;
        }
        else if(Yii::$app->user->can("gad_province_permission"))
        {
            $model->responsible_office_c = 2;
        }
        else if(Yii::$app->user->can("gad_ppdo_permission"))
        {
            $model->responsible_office_c = 2;
        }
        else if(Yii::$app->user->can("gad_region_permission"))
        {
            $model->responsible_office_c = 1;
        }

        $model->save();

        // \Yii::$app->getSession()->setFlash('success', "Action has been performed");
        // return $this->redirect(['/index', 'ruc' => $tuc,'onstep' => $valueOnStep, 'tocreate' => $valueToCreate]);

    }

    public function actionSessionEncode($trigger,$form_type,$report_type)
    {
        if($report_type == "ar") // if accomplishment report
        {
            if($form_type == "gender_issue") // if gender issue or gad mandate input form
            {
                if($trigger == "open")
                {
                    Yii::$app->session["encode_gender_ar"] = "open";
                }
                else
                {
                    Yii::$app->session["encode_gender_ar"] = "closed";
                }
            }
            else // if attributed program form
            {
                if($trigger == "open")
                {
                    Yii::$app->session["encode_attribute_ar"] = "open";
                }
                else
                {
                    Yii::$app->session["encode_attribute_ar"] = "closed";
                }
            }
        }
        else // if plan and budget report
        {
            if($form_type == "gender_issue") // if gender issue or gad mandate input form
            {
                if($trigger == "open")
                {
                    Yii::$app->session["encode_gender_pb"] = "open";
                }
                else
                {
                    Yii::$app->session["encode_gender_pb"] = "closed";
                }
            }
            else // if attributed program input form
            {
                if($trigger == "open")
                {
                    Yii::$app->session["encode_attribute_pb"] = "open";
                }
                else
                {
                    Yii::$app->session["encode_attribute_pb"] = "closed";
                }
            }
        }
    }
    public function actionLoadArActualCostExpenditure()
    {
        $qry = GadAccomplishmentReport::find()->select(["actual_cost_expenditure","id"])->where(['not', ['actual_cost_expenditure' => null]])->groupBy('actual_cost_expenditure')->all();
        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->actual_cost_expenditure
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadArTotalApprovedGadBudget()
    {
        $qry = GadAccomplishmentReport::find()->select(["total_approved_gad_budget","id"])->where(['not', ['total_approved_gad_budget' => null]])->groupBy('total_approved_gad_budget')->all();
        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->total_approved_gad_budget
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadArActualResults()
    {
        $qry = GadAccomplishmentReport::find()->select(["actual_results","id"])->where(['not', ['actual_results' => null]])->groupBy('actual_results')->all();
        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->actual_results
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadArTarget()
    {
        $qry = GadAccomplishmentReport::find()->select(["target","id"])->where(['not', ['target' => null]])->groupBy('target')->all();
        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->target
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadArPerformanceIndicator()
    {
        $qry = GadAccomplishmentReport::find()->select(["performance_indicator","id"])->where(['not', ['performance_indicator' => null]])->groupBy('performance_indicator')->all();
        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->performance_indicator
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadArActivity()
    {
        $qry = GadAccomplishmentReport::find()->select(["activity","id"])->where(['not', ['activity' => null]])->groupBy('activity')->all();
        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->activity
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadArRelevantLguPpa()
    {
        $qry = GadAccomplishmentReport::find()->select(["relevant_lgu_ppa","id"])->where(['not', ['relevant_lgu_ppa' => null]])->groupBy('relevant_lgu_ppa')->all();
        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->relevant_lgu_ppa
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadArObjective()
    {
        $qry = GadAccomplishmentReport::find()->select(["objective","id"])->where(['not', ['objective' => null]])->groupBy('objective')->all();
        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->objective
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadArCauseGenderIssue()
    {
        $qry = GadAccomplishmentReport::find()->select(["cause_gender_issue","id"])->where(['not', ['cause_gender_issue' => null]])->groupBy('cause_gender_issue')->all();
        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->cause_gender_issue
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadArPpaValue()
    {
        $qry = GadAccomplishmentReport::find()->select(["ppa_value","id"])->where(['not', ['ppa_value' => null]])->groupBy('ppa_value')->all();
        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->ppa_value
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionUpdateArVarianceRemarks($uid,$upd8_value)
    {
        $qry = GadArAttributedProgram::find()->where(['id' => $uid])->one();
        $qry->ar_ap_variance_remarks = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdateArGadAttributedProCost($uid,$upd8_value)
    {
        $qry = GadArAttributedProgram::find()->where(['id' => $uid])->one();
        $qry->gad_attributed_pro_cost = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdateArTotalAnnualProCost($uid,$upd8_value)
    {
        $qry = GadArAttributedProgram::find()->where(['id' => $uid])->one();
        $qry->total_annual_pro_cost = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdateArHgdgPimme($uid,$upd8_value)
    {
        $qry = GadArAttributedProgram::find()->where(['id' => $uid])->one();
        $qry->hgdg_pimme = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdateArApLguProgramProject($uid,$upd8_value)
    {
        $qry = GadArAttributedProgram::find()->where(['id' => $uid])->one();
        $qry->lgu_program_project = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public  function actionCreateArAttributedProgram($ruc,$onstep,$ppa_attributed_program_id,$ppa_attributed_program_others,$lgu_program_project,$hgdg_pimme,$total_annual_pro_cost,$ar_ap_variance_remarks,$controller_id,$tocreate,$checklist_id,$score_type)
    {
        // print_r($ppa_attributed_program_id); exit;
        $model = new GadArAttributedProgram();
        $model->record_tuc = $ruc;
        $model->ppa_attributed_program_id = $ppa_attributed_program_id;
        $model->ppa_attributed_program_others = $ppa_attributed_program_others;
        $model->lgu_program_project = $lgu_program_project;
        $model->hgdg_pimme = $hgdg_pimme;
        $model->total_annual_pro_cost = $total_annual_pro_cost;
        $model->ar_ap_variance_remarks = $ar_ap_variance_remarks;

        date_default_timezone_set("Asia/Manila");
        $model->date_created = date('Y-m-d');
        $model->time_created = date("h:i:sa");
        $model->controller_id = $controller_id;
        $model->score_type = $score_type;
        $model->checklist_id = $checklist_id;
        if($model->save())
        {
            return $this->redirect(['gad-accomplishment-report/index','ruc' => $ruc,'onstep'=>$onstep,'tocreate'=>$tocreate]);
        }
        else
        {
            \Yii::$app->response->format = 'json';
            return $model->errors;
        }
    }
    public function actionLoadArAttributedProCost()
    {
        $qry = GadArAttributedProgram::find()
        ->select(["gad_attributed_pro_cost","id"])
        ->where(['not', ['gad_attributed_pro_cost' => null]])
        ->groupBy('gad_attributed_pro_cost')
        ->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->gad_attributed_pro_cost
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadArTotalAnnualProCost()
    {
        $qry = GadArAttributedProgram::find()
        ->select(["total_annual_pro_cost","id"])
        ->where(['not', ['total_annual_pro_cost' => null]])
        ->groupBy('total_annual_pro_cost')
        ->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->total_annual_pro_cost
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadArHgdgPimme()
    {
        $qry = GadArAttributedProgram::find()
        ->select(["hgdg_pimme","id"])
        ->where(['not', ['hgdg_pimme' => null]])
        ->groupBy('hgdg_pimme')
        ->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->hgdg_pimme
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadArLguProgramProject()
    {
        $qry = GadArAttributedProgram::find()
        ->select(["lgu_program_project","id"])
        ->where(['not', ['lgu_program_project' => null]])
        ->groupBy('lgu_program_project')
        ->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->lgu_program_project
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadArPpaAttributedProgramOthers()
    {
        $qry = GadArAttributedProgram::find()
        ->select(["ppa_attributed_program_others","id"])
        ->where(['not', ['ppa_attributed_program_others' => null]])
        ->groupBy('ppa_attributed_program_others')
        ->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->ppa_attributed_program_others
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionUpd8ArVarianceRemark($uid,$upd8_value)
    {
        $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $uid])->one();
        $qry->variance_remarks = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpd8ArActualCostExpenditure($uid,$upd8_value)
    {
        $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $uid])->one();
        $qry->actual_cost_expenditure = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpd8ArTotalApprovedGadBudget($uid,$upd8_value)
    {
        $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $uid])->one();
        $qry->total_approved_gad_budget = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpd8ArActualResult($uid,$upd8_value)
    {
        $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $uid])->one();
        $qry->actual_results = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpd8ArTarget($uid,$upd8_value)
    {
        $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $uid])->one();
        $qry->target = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpd8ArPerformanceIndicator($uid,$upd8_value)
    {
        $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $uid])->one();
        $qry->performance_indicator = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpd8ArGadActivity($uid,$upd8_value)
    {
        $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $uid])->one();
        $qry->activity = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpd8ArRelevantLguPpa($uid,$upd8_value)
    {
        $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $uid])->one();
        $qry->relevant_lgu_ppa = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpd8ArGadObjective($uid,$upd8_value)
    {
        $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $uid])->one();
        $qry->objective = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpd8ArCauseGenderIssue($uid,$upd8_value)
    {
        $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $uid])->one();
        $qry->cause_gender_issue = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }

    public function actionCreateAccomplishmentReport($focused_id,$ppa_focused_id,$cause_gender_issue,$objective,$relevant_lgu_ppa,$activity,$performance_indicator,$target,$actual_results,$total_approved_gad_budget,$actual_cost_expenditure,$variance_remarks,$ppa_value,$inner_category_id,$ruc,$onstep,$tocreate,$cliorg_ppa_attributed_program_id,$gi_sup_data,$activity_category_id,$source)
    {
        $model = new \common\models\GadAccomplishmentReport();
        $model->focused_id = $focused_id;
        $model->ppa_focused_id = $ppa_focused_id;
        $model->cause_gender_issue = $cause_gender_issue;
        $model->objective = $objective;
        $model->relevant_lgu_ppa = $relevant_lgu_ppa;
        $model->activity = $activity;
        $model->performance_indicator = $performance_indicator;
        $model->target = $target;
        $model->actual_results = $actual_results;
        $model->total_approved_gad_budget = $total_approved_gad_budget;
        $model->actual_cost_expenditure = $actual_cost_expenditure;
        $model->variance_remarks = $variance_remarks;
        $model->ppa_value = $ppa_value;
        $model->inner_category_id = $inner_category_id;
        $model->record_tuc = $ruc;
        $model->cliorg_ppa_attributed_program_id = $cliorg_ppa_attributed_program_id;
        $model->gi_sup_data = $gi_sup_data;
        $model->source = $source;
        $model->activity_category_id = $activity_category_id;


        date_default_timezone_set("Asia/Manila");
        $model->date_created = date('Y-m-d');
        $model->time_created = date("h:i:sa");

        $miliseconds = round(microtime(true) * 1000);
        $hash =  md5(date('Y-m-d')."-".date("h-i-sa")."-".$miliseconds);
        $model->this_tuc = $hash;

        $qryRecord = \common\models\GadRecord::find()->where(['tuc' => $ruc])->one();
        $qryRecordId = !empty($qryRecord->id) ? $qryRecord->id : null;
        $model->record_id = $qryRecordId;

        if($model->save())
        {
            return $this->redirect(['gad-accomplishment-report/index', 'ruc' => $ruc,'onstep'=>$onstep,'tocreate'=>$tocreate]);
        }
        else
        {
            \Yii::$app->response->format = 'json';
            return $model->errors;
        }
    }

    public function actionUpdatePbFooterDate($uid,$upd8_value)
    {

        $qry = GadRecord::find()->where(['id' => $uid])->one();
        $qry->footer_date = date('Y-m-d',strtotime($upd8_value));
        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";

            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        return $upd8_value;
    }
    public function actionUpdatePbApprovedBy($uid,$upd8_value)
    {
        $qry = GadRecord::find()->where(['id' => $uid])->one();
        $qry->approved_by = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdatePbPreparedBy($uid,$upd8_value)
    {
        $qry = GadRecord::find()->where(['id' => $uid])->one();
        $qry->prepared_by = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdateApLeadResponsibleOffice($uid,$upd8_value)
    {
        $qry = GadAttributedProgram::find()->where(['id' => $uid])->one();
        $qry->ap_lead_responsible_office = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdateAttributedProBudget($uid,$upd8_value)
    {
        $qry = GadAttributedProgram::find()->where(['id' => $uid])->one();
        $qry->attributed_pro_budget = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdateTotalAnnualProBudget($uid,$upd8_value)
    {
        $qry = GadAttributedProgram::find()->where(['id' => $uid])->one();
        $qry->total_annual_pro_budget = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdateHgdg($uid,$upd8_value)
    {
        $qry = GadAttributedProgram::find()->where(['id' => $uid])->one();
        $qry->hgdg = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdateApLguProgramProject($uid,$upd8_value)
    {
        $qry = GadAttributedProgram::find()->where(['id' => $uid])->one();
        $qry->lgu_program_project = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    // public  function actionCreatePbAttributedProgram($ruc,$onstep,$ppa_attributed_program_id,$lgu_program_project,$hgdg,$total_annual_pro_budget,$lead_responsible_office,$controller_id,$tocreate,$file_upload,$folder_type)
    public  function actionCreatePbAttributedProgram()
    {
        $model = new GadAttributedProgram();
        $upload = new GadFileAttached();
        $arrVal = Yii::$app->request->post();
        $model->record_tuc = $arrVal["ruc"];
        $model->ppa_attributed_program_id = $arrVal["ppa_attributed_program_id"];
        $model->lgu_program_project = $arrVal["lgu_program_project"];
        $model->hgdg = $arrVal["hgdg"];
        $model->total_annual_pro_budget = $arrVal["total_annual_pro_budget"];
        $model->ap_lead_responsible_office = $arrVal["lead_responsible_office"];
        $model->checklist_id = $arrVal["checklist_id"];

        date_default_timezone_set("Asia/Manila");
        $model->date_created = date('Y-m-d');
        $model->time_created = date("h:i:sa");
        $model->controller_id = $arrVal["controller_id"];

        if($model->save())
        {
            \Yii::$app->response->format = 'json';
            return "true";
        }
        else
        {
            \Yii::$app->response->format = 'json';
            return $model->errors;
        }

    }
    public function actionLoadApLeadResponsibleOffice()
    {
        $qry = GadAttributedProgram::find()
        ->select(["ap_lead_responsible_office","id"])
        ->where(['not', ['ap_lead_responsible_office' => null]])
        ->groupBy('ap_lead_responsible_office')
        ->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->ap_lead_responsible_office
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadAttributedProBudget()
    {
        $qry = GadAttributedProgram::find()
        ->select(["attributed_pro_budget","id"])
        ->where(['not', ['attributed_pro_budget' => null]])
        ->groupBy('attributed_pro_budget')
        ->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->attributed_pro_budget
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadTotalAnnualProBudget()
    {
        $qry = GadAttributedProgram::find()
        ->select(["total_annual_pro_budget","id"])
        ->where(['not', ['total_annual_pro_budget' => null]])
        ->groupBy('total_annual_pro_budget')
        ->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->total_annual_pro_budget
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadHgdg()
    {
        $qry = GadAttributedProgram::find()
        ->select(["hgdg","id"])
        ->where(['not', ['hgdg' => null]])
        ->groupBy('hgdg')
        ->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->hgdg
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadLguProgramProject()
    {
        $qry = GadAttributedProgram::find()
        ->select(["lgu_program_project","id"])
        ->where(['not', ['lgu_program_project' => null]])
        ->groupBy('lgu_program_project')
        ->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->lgu_program_project
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadPpaAttributedProgramOthers()
    {
        $qry = GadAttributedProgram::find()
        ->select(["ppa_attributed_program_others","id"])
        ->where(['not', ['ppa_attributed_program_others' => null]])
        ->groupBy('ppa_attributed_program_others')
        ->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->ppa_attributed_program_others
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }

    public function actionLoadPpaCategory($focused_id)
    {
        if($focused_id == 1)
        {
            $qry = GadPpaClientFocused::find()->all();
        }
        else
        {
            $qry = GadPpaOrganizationalFocused::find()->all();
        }
        
        $arr = [];
        $arr[] = ['id'=>'','text'=>''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'text' => $item->title
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;
    }
    public function actionDeleteComment($comment_id)
    {
        $model = GadComment::find()->where(['id' => $comment_id])->one();
        if($model->delete())
        {
            return "ok";
        }
        else
        {
            return "error";
        }
    }
    public function actionUpdateComment($comment_id,$comment_value)
    {
        $model = GadComment::find()->where(['id' => $comment_id])->one();
        $model->comment = $comment_value;
        if($model->save())
        {
            return $comment_value;
        }
        else
        {
            return "update_comment_error_occured";
        }
    }

    public function actionUpdateAttachedAr($record_id,$ruc,$tocreate,$onstep)
    {
        // $record_id is the accomplishment rcord id
        if(GadRecord::find()->where(['tuc' => $ruc,'attached_ar_record_id' => $record_id])->exists())
        {
            GadRecord::updateAll(['attached_ar_record_id' => null], 'tuc = "'.$ruc.'" ');
            \Yii::$app->getSession()->setFlash('warning', "Attached has been removed");
        }
        else
        {
            GadRecord::updateAll(['attached_ar_record_id' => $record_id], 'tuc = "'.$ruc.'" ');
            \Yii::$app->getSession()->setFlash('success', "Accomplishment Report has been attached");
        }

        return $this->redirect(['gad-plan-budget/index','ruc' => $ruc,'onstep'=>$onstep,'tocreate'=>$tocreate]);
    }

    public function actionLoadAr($params)
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
        $QueryComma = GadRecord::find()->select(['attached_ar_record_id'])->where(['not',['attached_ar_record_id' => null]])->all();
        foreach ($QueryComma as $key => $row) {
            # code...
            $arrComma[] = $row["attached_ar_record_id"];
        }

        $QueryGetArId = GadRecord::find()->where(['tuc' => $params])->one();

        $arrComma2 = [];
        $QueryComma2 = GadRecord::find()->select(["id"])->where(['not',['id' => $arrComma]])->andWhere(['report_type_id' => 2])->orWhere(['id' => $QueryGetArId->attached_ar_record_id])->all();

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
            'PRV.province_m as province_name',
            'CTC.citymun_m as citymun_name',
            'REC.status as record_status',
            'REC.total_lgu_budget',
            'REC.year',
            'REC.prepared_by',
            'REC.approved_by',
            'REC.id as record_id',
            'REC.attached_ar_record_id as ar_id'
        ])
        ->from('gad_record REC')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = REC.region_c')
        ->leftJoin(['PRV' => 'tblprovince'], 'PRV.province_c = REC.province_c')
        ->leftJoin(['CTC' => 'tblcitymun'], 'CTC.citymun_c = REC.citymun_c AND CTC.province_c = REC.province_c')
        ->where(['REC.report_type_id' => 2])
        ->andWhere($condition)
        // ->andWhere($condition3)
        ->andFilterWhere($condition2)
        ->andWhere(['REC.is_archive' => 0])
        // ->andFilterWhere(['REC.id' => ])
        ->groupBy(['REC.id'])
        ->orderBy(['REC.id' => SORT_DESC])
        ->all();
        // ->createCommand()->rawSql;
        // print_r($qry); /exit;

        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [

                        'province_name' => $item["province_name"],
                        'citymun_name' => $item["citymun_name"],
                        'record_id' => $item["record_id"],
                        'total_lgu_budget' => $item["total_lgu_budget"],
                        'year' => $item["year"],
                        'prepared_by' => $item["prepared_by"],
                        'approved_by' => $item["approved_by"],
                        'ar_id' => $item["ar_id"],
                     ];
        }
        
        \Yii::$app->response->format = 'json';
        return $arr;
    }

    public function actionLoadComment($id,$attribute,$controller_id,$form_id)
    {
        $qry = (new \yii\db\Query())
        ->select([
            'GC.id as comment_id',
            'GC.comment as comment_value',
            'REG.region_m as region_name',
            'PRV.province_m as province_name',
            'CTC.citymun_m as citymun_name',
            'GC.user_id as user_uid',
            'GC.date_created',
            'GC.time_created',
            'CONCAT(UI.FIRST_M," ",UI.LAST_M) as full_name',
            'OFC.OFFICE_M as office_name'

        ])
        ->from('gad_comment GC')
        ->leftJoin(['UI' => 'user_info'], 'UI.user_id = GC.user_id')
        ->leftJoin(['OFC' => 'tbloffice'], 'OFC.OFFICE_C = GC.office_c')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = GC.region_c')
        ->leftJoin(['PRV' => 'tblprovince'], 'PRV.province_c = GC.province_c')
        ->leftJoin(['CTC' => 'tblcitymun'], 'CTC.citymun_c = GC.citymun_c AND CTC.province_c = GC.province_c')
        ->where(['GC.plan_budget_id' => $id, 'GC.attribute_name' => $attribute,'GC.controller_id' => $controller_id,'form_id' => $form_id])
        ->groupBy(['GC.id'])
        ->orderBy(['GC.id' => SORT_DESC])
        ->all();
        // ->createCommand()->rawSql;
        // $qry = GadComment::find()->select(["id","comment"])->where(["plan_budget_id" => $id, "attribute_name" => $attribute])->orderBy(["id" => SORT_DESC])->all();
        // print_r($qry); exit;
        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'comment_id' => $item["comment_id"],
                        'comment' => $item["comment_value"],
                        'region_name' => $item["region_name"],
                        'province_name' => $item["province_name"],
                        'citymun_name' => $item["citymun_name"],
                        'date_created' => date("F j, Y", strtotime($item["date_created"])),
                        'time_created' => $item["time_created"],
                        'full_name' => $item["full_name"],
                        'office_name' => $item["office_name"],
                        'user_id_comment' => $item["user_uid"],
                        'user_id_login' => Yii::$app->user->identity->userinfo->user_id
                     ];
        }
        
        \Yii::$app->response->format = 'json';
        return $arr;
    }

    public function actionLoadArGenderIssueSupData($record_id)
    {
        $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $record_id, 'inner_category_id' => 1])->one();
        $value = !empty($qry->gi_sup_data) ? $qry->gi_sup_data : "";

        \Yii::$app->response->format = 'json';
        return $value;
    }

    public function actionLoadGenderIssueSupData($record_id)
    {
        $qry = \common\models\GadPlanBudget::find()->where(['id' => $record_id, 'inner_category_id' => 1])->one();
        $value = !empty($qry->gi_sup_data) ? $qry->gi_sup_data : "";

        \Yii::$app->response->format = 'json';
        return $value;
    }

    public function HasComment($record_id,$plan_budget_id,$attribute_name,$model_name)
    {
        $count = \common\models\GadComment::find()->where(['record_id' => $record_id, 'plan_budget_id' => $plan_budget_id, 'attribute_name' => $attribute_name,'model_name' => $model_name])->count();

        return $count;
    }

    public function countComment($id,$attribute)
    {
        $qry = \common\models\GadComment::find()->where(['plan_budget_id' => $id, 'attribute_name' => $attribute])->count();
        return $qry;
    }

    public function countComment2($controller_id,$form_id,$id,$attribute)
    {
        // $qry = \common\models\GadComment::find()
        // ->where([
        //     'plan_budget_id' => $id, 
        //     'attribute_name' => $attribute,
        //     'controller_id' => $controller_id, 
        //     'form_id' => $form_id
        // ])->count();
        // print_r($qry->createCommand()->rawSql); exit;
        // print_r("hello".$qry); exit;
        // return $qry;
        return 0;
    }

    public function actionSaveComment($plan_budget_id,$comment,$attribute_name,$record_uc,$controller_id,$form_id)
    {
        $model = new \common\models\GadComment();
        $model->plan_budget_id = $plan_budget_id;
        $model->comment = $comment;
        $model->attribute_name = $attribute_name;
        date_default_timezone_set("Asia/Manila");
        $model->date_created = date('Y-m-d');
        $model->time_created = date("h:i:sa");
        $model->user_id = Yii::$app->user->identity->userinfo->user_id;
        $office_value = 0;
        if(Yii::$app->user->can("gad_lgu"))
        {
            $office_value = 0;
        }
        else if(Yii::$app->user->can("gad_field"))
        {
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS") 
            {
                $office_value = 4;
            }
            else
            {
                $office_value = 3;
            }
            
        }
        else if(Yii::$app->user->can("gad_region"))
        {
            $office_value = 1;
        }
        else if(Yii::$app->user->can("gad_province"))
        {
            $office_value = 2;
        }
        else if(Yii::$app->user->can("gad_central"))
        {
            $office_value = 5;
        }

        $model->office_c = $office_value;
        $model->region_c = !empty(Yii::$app->user->identity->userinfo->REGION_C) ? Yii::$app->user->identity->userinfo->REGION_C : NULL;
        $model->province_c = !empty(Yii::$app->user->identity->userinfo->PROVINCE_C) ? Yii::$app->user->identity->userinfo->PROVINCE_C : NULL;
        $model->citymun_c = !empty(Yii::$app->user->identity->userinfo->CITYMUN_C) ? Yii::$app->user->identity->userinfo->CITYMUN_C : NULL;
        $model->record_tuc = $record_uc;

        $qryRecord = \common\models\GadRecord::find()->where(['tuc' => $record_uc])->one();
        $qryRecordId = !empty($qryRecord->id) ? $qryRecord->id : null;
        $model->record_id = $qryRecordId;
        $model->controller_id = $controller_id;
        $model->form_id = $form_id;

        if($model->save())
        {
            $is_save = $comment;
        }else
        {
            $is_save = "";
            foreach ($model->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;

    }   
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionLoadPpaValue()
    {
        $qry = GadPlanBudget::find()->select(["ppa_value","id"])->where(['not', ['ppa_value' => null]])->groupBy('ppa_value')->all();
        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->ppa_value
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
     public function actionLoadLeadResponsible()
    {
        $qry = GadPlanBudget::find()->select(["lead_responsible_office","id"])->where(['not', ['lead_responsible_office' => null]])->groupBy('lead_responsible_office')->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->lead_responsible_office
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadBudgetCo()
    {
        $qry = GadPlanBudget::find()->select(["budget_co","id"])->where(['not', ['budget_co' => null]])->groupBy('budget_co')->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->budget_co
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadBudgetPs()
    {
        $qry = GadPlanBudget::find()->select(["budget_ps","id"])->where(['not', ['budget_ps' => null]])->groupBy('budget_ps')->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->budget_ps
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadBudgetMooe()
    {
        $qry = GadPlanBudget::find()->select(["budget_mooe","id"])->where(['not', ['budget_mooe' => null]])->groupBy('budget_mooe')->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->budget_mooe
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
     public function actionLoadPerformanceIndicator()
    {
        $qry = GadPlanBudget::find()->select(["performance_indicator","id"])->where(['not', ['performance_indicator' => null]])->groupBy('performance_indicator')->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->performance_indicator
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
     public function actionLoadPerformanceTarget()
    {
        $qry = GadPlanBudget::find()->select(["performance_target","id"])->where(['not', ['performance_target' => null]])->groupBy('performance_target')->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->performance_target
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
    public function actionLoadActivity()
    {
        $qry = GadPlanBudget::find()->select(["activity","id"])->where(['not', ['activity' => null]])->groupBy('activity')->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->activity
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
     public function actionLoadRelevantLgu()
    {
        $qry = GadPlanBudget::find()->select(["relevant_lgu_program_project","id"])->where(['not', ['relevant_lgu_program_project' => null]])->groupBy('relevant_lgu_program_project')->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->relevant_lgu_program_project
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }

    public function actionLoadCauseGenderIssue()
    {
        $qry = GadPlanBudget::find()->select(["cause_gender_issue","id"])->where(['not', ['cause_gender_issue' => null]])->groupBy('cause_gender_issue')->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->cause_gender_issue
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }

    public function actionLoadPbObjective()
    {
        $qry = GadPlanBudget::find()->select(["objective","id"])->where(['not', ['objective' => null]])->groupBy('objective')->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
        foreach ($qry as  $item) {
            $arr[] = [
                        'id' => $item->id,
                        'title' => $item->objective
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }

    public function actionCreateGadPlanBudget($ppa_focused_id,$ppa_value,$issue,$obj,$relevant,$act,$performance_target,$ruc,$budget_mooe,$budget_ps,$budget_co,$lead_responsible_office,$focused_id,$inner_category_id,$onstep,$tocreate,$cliorg_ppa_attributed_program_id,$gi_sup_data,$date_implement_start,$date_implement_end,$activity_category_id,$source)
    {
        $model = new \common\models\GadPlanBudget();
        $model->cause_gender_issue = $issue;
        $model->objective = $obj;
        $model->relevant_lgu_program_project = $relevant;
        $model->activity = $act;
        $model->performance_target = $performance_target;
        // $model->performance_indicator = $performance_indicator;
        $model->record_tuc = $ruc;
        $model->ppa_value = !empty($ppa_value) ? $ppa_value : null;
        $model->ppa_focused_id = $ppa_focused_id;
        $model->budget_mooe = $budget_mooe;
        $model->budget_ps = $budget_ps;
        $model->budget_co = $budget_co;
        $model->lead_responsible_office = $lead_responsible_office;
        $model->focused_id = $focused_id;
        $model->inner_category_id = $inner_category_id;
        $model->cliorg_ppa_attributed_program_id = $cliorg_ppa_attributed_program_id;
        $model->gi_sup_data = $gi_sup_data;
        $model->date_implement_end = $date_implement_end;
        $model->date_implement_start = $date_implement_start;
        $model->activity_category_id = $activity_category_id;

        $qryRecord = \common\models\GadRecord::find()->where(['tuc' => $ruc])->one();
        $qryRecordId = !empty($qryRecord->id) ? $qryRecord->id : null;
        $model->record_id = $qryRecordId;
        $model->source = $source;


        date_default_timezone_set("Asia/Manila");
        $model->date_created = date('Y-m-d');
        $model->time_created = date("h:i:sa");
        if($model->save())
        {
            \Yii::$app->getSession()->setFlash('success', "Data has been saved");
            return $this->redirect(['gad-plan-budget/index','ruc' => $ruc,'onstep'=>$onstep,'tocreate'=>$tocreate]);
        }
        else
        {
            \Yii::$app->response->format = 'json';
            return $model->errors;
        }

    }

    public function actionUpdatePbLeadResponsibleOffice($uid,$upd8_value)
    {
        $qry = \common\models\GadPlanBudget::find()->where(['id' => $uid])->one();
        $qry->lead_responsible_office = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdateBudgetCo($uid,$upd8_value)
    {
        $qry = \common\models\GadPlanBudget::find()->where(['id' => $uid])->one();
        $qry->budget_co = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdateBudgetPs($uid,$upd8_value)
    {
        $qry = \common\models\GadPlanBudget::find()->where(['id' => $uid])->one();
        $qry->budget_ps = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdateBudgetMooe($uid,$upd8_value)
    {
        $qry = \common\models\GadPlanBudget::find()->where(['id' => $uid])->one();
        $qry->budget_mooe = $upd8_value;

        // print_r(Yii::$app->controller->action->id); exit;
        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }
    public function actionUpdatePerformanceIndicator($uid,$upd8_value)
    {
        $qry = \common\models\GadPlanBudget::find()->where(['id' => $uid])->one();
        $qry->performance_indicator = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }

    public function actionUpdatePerformanceTarget($uid,$upd8_value)
    {
        $qry = \common\models\GadPlanBudget::find()->where(['id' => $uid])->one();
        $qry->performance_target = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }

    public function actionUpdateActivity($uid,$upd8_value)
    {
        $qry = \common\models\GadPlanBudget::find()->where(['id' => $uid])->one();
        $qry->activity = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }

    public function actionUpdatePpaValue($uid,$upd8_value)
    {
        $qry = \common\models\GadPlanBudget::find()->where(['id' => $uid])->one();
        $qry->ppa_value = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }

        
        return $is_save;
    }

    public function actionUpdateArPpaValue($uid,$upd8_value)
    {
        $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $uid])->one();
        $qry->ppa_value = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }

        
        return $is_save;
    }

    public function actionUpdateObjective($uid,$upd8_value)
    {
       	$qry = \common\models\GadPlanBudget::find()->where(['id' => $uid])->one();
        $qry->objective = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }

    public function actionUpdateGenderIssueSupData($uid,$upd8_value,$controller_id)
    {
        if($controller_id == "gad-accomplishment-report")
        {
            $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $uid])->one();
        }
        else
        {
            $qry = \common\models\GadPlanBudget::find()->where(['id' => $uid])->one();
        }
        
        
        $qry->gi_sup_data = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }

    public function actionUpdateSource($uid,$ta_edit_source,$controller_id)
    {
        if($controller_id == "gad-accomplishment-report")
        {
            $qry = \common\models\GadAccomplishmentReport::find()->where(['id' => $uid])->one();
        }
        else
        {
            $qry = \common\models\GadPlanBudget::find()->where(['id' => $uid])->one();
        }
        
        $qry->source = $ta_edit_source;

        if($qry->save())
        {
            $is_save = $ta_edit_source;
        }
        else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }

    public function actionUpdateRelevantLguProgramProject($uid,$upd8_value)
    {
        $qry = \common\models\GadPlanBudget::find()->where(['id' => $uid])->one();
        $qry->relevant_lgu_program_project = $upd8_value;

        if($qry->save())
        {
            $is_save = $upd8_value;
        }else
        {
            $is_save = "";
            foreach ($qry->errors as $key => $value) {
                $is_save = $value[0];
            }
        }
        
        return $is_save;
    }

    public function actionFindProvinceByRegion($region_c)
    {
        $qry = Province::find()->where(['region_c'=>$region_c])->all();
        $arr = [];
        $arr[] = ['id'=>'','text'=>''];
        foreach ($qry as  $Item) {
            $arr[] = [
                        'id' => $Item->province_c,
                        'text' => $Item->province_m,
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }

    public function actionFindCitymunByProvince($province_c)
    {
        $qry = Citymun::find()->where(['province_c'=>$province_c])->all();
        $arr = [];
        $arr[] = ['id'=>'','text'=>''];
        foreach ($qry as  $Item) {
            $arr[] = [
                        'id' => $Item->citymun_c,
                        'text' => $Item->citymun_m,
                     ];
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }
}
