<?php

namespace common\modules\report\controllers;

use Yii;

class PrintController extends \yii\web\Controller
{
    public function actionGadPlanBudget()
    {
    	$this->layout = "print";

        return $this->render('plan',[
        	'dataPlanBudget' => Yii::$app->session['session_dataPlanBudget'],
        	'dataAttributedProgram' => Yii::$app->session['session_dataPlanAttributedProgram'],
        	'dataRecord' => Yii::$app->session['session_dataPlanRecord']
        ]);
    }

}
