<?php

namespace common\modules\admin\controllers;
use Yii;

class SettingsController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	Yii::$app->session["activelink"] = "settings";
        return $this->render('index');
    }

}
