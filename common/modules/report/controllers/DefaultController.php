<?php

namespace common\modules\report\controllers;

use yii\web\Controller;
use niksko12\user\models\UserInfo;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;
use common\models\GadPlanBudget;
/**
 * Default controller for the `report` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionLoadPpaValue()
    {
        $qry = GadPlanBudget::find()->select(["ppa_value","id"])->where(['not', ['ppa_value' => null]])->groupBy('ppa_value')->all();
        $arr = [];
        $arr[] = ['id'=>'', 'title' => ''];
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

    public function actionCreateGadPlanBudget($ppa_focused_id,$ppa_value,$issue,$obj,$relevant,$act,$performance_target,$performance_indicator,$ruc,$budget_mooe,$budget_ps,$budget_co,$lead_responsible_office)
    {
        $model = new \common\models\GadPlanBudget();
        $model->cause_gender_issue = $issue;
        $model->objective = $obj;
        $model->relevant_lgu_program_project = $relevant;
        $model->activity = $act;
        $model->performance_target = $performance_target;
        $model->performance_indicator = $performance_indicator;
        $model->record_tuc = $ruc;
        $model->ppa_value = !empty($ppa_value) ? $ppa_value : null;
        $model->ppa_focused_id = $ppa_focused_id;
        $model->budget_mooe = $budget_mooe;
        $model->budget_ps = $budget_ps;
        $model->budget_co = $budget_co;
        $model->lead_responsible_office = $lead_responsible_office;

        if($model->save())
        {
            return $this->redirect(['gad-plan-budget/index','ruc' => $ruc]);
        }
        else
        {
            \Yii::$app->response->format = 'json';
            return $model->errors;
        }

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
        	$is_save = "error_in_saving";

            $qry->errors;
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
