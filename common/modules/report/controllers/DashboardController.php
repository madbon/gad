<?php

namespace common\modules\report\controllers;
use common\models\GadStatus;
use common\models\GadRecord;
use Yii;

class DashboardController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	Yii::$app->session["activelink"] = "dashboard";

    	// $query = (new \yii\db\Query())
     //    ->select([
     //    	'COUNT(REC.id) as count_status',
     //    	'STAT.title as status_name',
     //    	'STAT.code as status_code',
     //    	'REG.region_m as region_name',
     //    	'REG.region_c as region_code'
     //    	// 'PROV.province_m as province_name',
     //    	// 'PROV.province_c as province_code',
     //    	// 'CIT.citymun_m as citymun_name',
     //    	// 'CIT.citymun_c as citymun_code'
     //    ])
     //    ->from('gad_status STAT')
     //    ->leftJoin(['REC' => 'gad_record'], 'REC.status = STAT.code')
     //    ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = REC.region_c')
     //    ->leftJoin(['PROV' => 'tblprovince'], 'PROV.province_c = REC.province_c')
     //    ->leftJoin(['CIT' => 'tblcitymun'], 'CIT.citymun_c = REC.citymun_c AND CIT.province_c = REC.province_c')
     //    ->groupBy(['STAT.code','REG.region_c']);
     //    // ->all();

     //    // echo "<pre>";
     //    print_r($query->createCommand()->rawSql); exit;
    	
        return $this->render('index');
    }

}
