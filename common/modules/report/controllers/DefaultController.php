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

    public function actionLoadPbObjective()
    {
        $qry = GadPlanBudget::find()->select(["objective","id"])->groupBy('objective')->all();
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

    public function actionCreateGadPlanBudget($focused,$issue,$obj,$relevant,$act,$perform,$ruc)
    {
        $model = new \common\models\GadPlanBudget();
        // $model->record_id = $rec_id;
        // $model->focused_id = $foc_id;
        // $model->issue_or_mandate

        $model->issue_mandate = $issue;
        $model->objective = $obj;
        $model->relevant_lgu_program_project = $relevant;
        $model->activity = $act;
        $model->performance_indicator_target = $perform;
        $model->record_tuc = $ruc;
        $model->ppa_value = $focused;

        if($model->save())
        {
            return $this->redirect(['gad-plan-budget/index','ruc' => $ruc]);
        }
        else
        {
            \Yii::$app->response->format = 'json';
            return $model->errors;
        }
        
        // return $is_save;
    }

    public function actionUpdateObjective($id,$obj_val)
    {
       	$qry = \common\models\GadPlanBudget::find()->where(['id' => $id])->one();
        $qry->objective = $obj_val;
        

        if($qry->save())
        {
        	$is_save = $obj_val;
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
