<?php

namespace common\modules\report\controllers;
use common\modules\report\controllers\DefaultController;

use Yii;

class PrintController extends \yii\web\Controller
{
    public function actionGadPlanBudget($region,$province,$citymun,$grand_total,$total_lgu_budget,$ruc)
    {
    	$this->layout = "print";

        return $this->render('gad-plan-budget',[
        	'dataPlanBudget' => Yii::$app->session['session_dataPlanBudget'],
        	'dataAttributedProgram' => Yii::$app->session['session_dataPlanAttributedProgram'],
        	'dataRecord' => Yii::$app->session['session_dataPlanRecord'],
            'region' => $region,
            'province' => $province,
            'citymun' => $citymun,
            'grand_total' => $grand_total,
            'total_lgu_budget' => $total_lgu_budget,
            'year' => DefaultController::GetPlanYear($ruc),
        ]);
    }

    public function actionGpbClientOrganizationFocused($region,$province,$citymun,$grand_total,$total_lgu_budget,$ruc)
    {
    	$this->layout = "print";

        return $this->render('gpb-client-organization-focused',[
        	'dataPlanBudget' => Yii::$app->session['session_dataPlanBudget'],
        	'dataRecord' => Yii::$app->session['session_dataPlanRecord'],
            'region' => $region,
            'province' => $province,
            'citymun' => $citymun,
            'grand_total' => $grand_total,
            'total_lgu_budget' => $total_lgu_budget,
            'year' => DefaultController::GetPlanYear($ruc),
        ]);
    }

    public function actionGpbAttributedProgram()
    {
    	$this->layout = "print";
        return $this->render('gpb-attributed-program',[
        	'dataAttributedProgram' => Yii::$app->session['session_dataPlanAttributedProgram'],
        	'dataRecord' => Yii::$app->session['session_dataPlanRecord']
        ]);
    }

    public function actionAccomplishmentReport($region,$province,$citymun,$grand_total,$total_lgu_budget,$ruc)
    {
    	$this->layout = "print";
        return $this->render('accomplishment-report',[
        	'dataAR' => Yii::$app->session["session_arDataAccomplishment"],
        	'dataRecord' => Yii::$app->session["session_arDataRecord"],
        	'dataAttributedProgram' => Yii::$app->session["session_arDataAttributedProgram"],
            'year' => DefaultController::GetPlanYear($ruc),
        ]);
    }

    public function actionArClientOrganizationFocused($region,$province,$citymun,$grand_total,$total_lgu_budget,$ruc)
    {
    	$this->layout = "print";
        return $this->render('ar-client-organization-focused',[
        	'dataAR' => Yii::$app->session["session_arDataAccomplishment"],
        	'dataRecord' => Yii::$app->session["session_arDataRecord"],
            'year' => DefaultController::GetPlanYear($ruc),
        ]);
    }

    public function actionArAttributedProgram()
    {
    	$this->layout = "print";
        return $this->render('ar-attributed-program',[
        	'dataAttributedProgram' => Yii::$app->session["session_arDataAttributedProgram"],
        	'dataRecord' => Yii::$app->session["session_arDataRecord"],
        ]);
    }

}
