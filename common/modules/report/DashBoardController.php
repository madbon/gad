<?php

namespace common\modules\report;

class DashBoardController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
