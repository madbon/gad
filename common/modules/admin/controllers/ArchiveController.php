<?php

namespace common\modules\admin\controllers;

use Yii;
use common\modules\report\models\GadRecordSearch;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;
use yii\helpers\ArrayHelper;
use common\models\GadStatus;
use common\models\GadYear;
use common\models\ArchiveHistory;
use common\models\GadRecord;
use common\modules\report\controllers\DefaultController as Tools;

class ArchiveController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	Yii::$app->session["activelink"] = NULL;
    	$searchModel = new GadRecordSearch();

        

        $regionCondition = [];
        $provinceCondition = [];
        $citymunCondition = [];
        $statusCondition = [];

        if(Yii::$app->user->can("gad_lgu_permission")) // C/MLGOO
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $citymunCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C, 'citymun_c' => $searchModel->citymun_c  = Yii::$app->user->identity->userinfo->CITYMUN_C];

            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS")
            {
                $statusCondition = Tools::ViewStatus("gad_lgu_huc");
            }
            else
            {
                $statusCondition = Tools::ViewStatus("gad_lgu_non_huc");
            }
        }
        else if(Yii::$app->user->can("gad_region_permission")) // Regional Office
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $statusCondition = Tools::ViewStatus("gad_region_dilg");

            if(!empty($searchModel->citymun_c) || !empty($searchModel->province_c))
            {
                $citymunCondition = ['province_c' => $searchModel->province_c];
            }
            else
            {
                $citymunCondition = ['region_c' => 0];
            }
        }
        else if(Yii::$app->user->can("gad_province_permission")) // Provincial Office
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $citymunCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $statusCondition = Tools::ViewStatus("gad_province_dilg");
        } 
        else if(Yii::$app->user->can("gad_lgu_province_permission"))
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $citymunCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $statusCondition = Tools::ViewStatus("gad_province_dilg");
        }
        else if(Yii::$app->user->can("gad_ppdo_permission"))
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $citymunCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $statusCondition = Tools::ViewStatus("gad_ppdo");
        }
        else if(Yii::$app->user->can("gad_central_permission") || Yii::$app->user->can("gad_admin_permission"))
        {
            $provinceCondition = ['region_c' => $searchModel->region_c];
            $citymunCondition = ['province_c' => $searchModel->province_c];
            $statusCondition = Tools::ViewStatus("gad_all_status");
        }
        else
        {
            $provinceCondition = ['region_c' => $searchModel->region_c];
            $citymunCondition = ['province_c' => $searchModel->province_c];
            $statusCondition = Tools::ViewStatus("gad_all_status");
        }
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $region = ArrayHelper::map(Region::find()->where($regionCondition)->all(), 'region_c', 'region_m');
        $province = ArrayHelper::map(Province::find()->where($provinceCondition)->all(), 'province_c', 'province_m');
        $citymun = ArrayHelper::map(Citymun::find()->where($citymunCondition)->all(), 'citymun_c', 'citymun_m');
        $statusList = ArrayHelper::map(GadStatus::find()->where(['code' => $statusCondition])->all(), 'code', 'title');
        $arrayYear = ArrayHelper::map(GadYear::find()->orderBy(['value' => SORT_DESC])->all(), 'value', 'value');

        return $this->render('index', [
        	'dataProvider' => $dataProvider,
        	'model' => $searchModel,
        	'region' => $region,
            'province' => $province,
            'citymun' => $citymun,
            'statusList' => $statusList,
            'arrayYear' => $arrayYear
        ]);
    }

    public function actionArchiveDetails($ruc)
   	{
   		$query = ArchiveHistory::find()->where(['record_tuc' => $ruc])->all();

   		return $this->renderAjax('archive_details', [
   			'data' => $query
   		]);
   	}

    public function actionRestore($report_type,$record_id)
    {
        $searchModel = new GadRecordSearch();
        $dataProvider = Yii::$app->session["GadRecordSearch"];
        $gadRecord = GadRecord::find()->where(['id' => $record_id])->one();
        $status_id = !empty($gadRecord->status) ? $gadRecord->status : null;
        $record_tuc = !empty($gadRecord->tuc) ? $gadRecord->tuc : null;
        $arrQue = [];
        $varArchiveByName = "";

        if(empty($record_id))
        {
            foreach ($dataProvider->query->all() as $key => $row) {
                date_default_timezone_set("Asia/Manila");
                $arrQue[] = $row["record_id"];
                $archiveHistory = new ArchiveHistory();
                $archiveHistory->record_id = $row["record_id"];
                $archiveHistory->record_tuc = $row["record_tuc"];
                $archiveHistory->archiveby_userid = Yii::$app->user->identity->id;
                if(Yii::$app->user->can("gad_admin") || Yii::$app->user->can("SuperAdministrator"))
                {
                    $archiveHistory->archiveby_name = "Super Administrator";
                }
                else
                {
                    $archiveHistory->archiveby_name = Yii::$app->user->identity->userinfo->FIRST_M." ".Yii::$app->user->identity->userinfo->LAST_M;
                }
                
                $archiveHistory->remarks = "Report has been restored (system_generated_remarks)";
                $archiveHistory->status = $row["record_status"];
                $archiveHistory->date_created = date("Y-m-d");
                $archiveHistory->time_created = date("h:i:sa");
                $archiveHistory->save();
            }
        }
        else
        {
            $archiveHistory = new ArchiveHistory();
            $archiveHistory->record_id = $record_id;
            $archiveHistory->record_tuc = $record_tuc;
            $archiveHistory->archiveby_userid = Yii::$app->user->identity->id;
            if(Yii::$app->user->can("gad_admin") || Yii::$app->user->can("SuperAdministrator"))
            {
                $archiveHistory->archiveby_name = "Super Administrator";
            }
            else if(Yii::$app->user->can("Administrator"))
            {
                $archiveHistory->archiveby_name = "Administrator";
            }
            else if(Yii::$app->user->can("RegionalAdministrator"))
            {
                $archiveHistory->archiveby_name = "Regional Administrator";
            }
            else
            {
                $archiveHistory->archiveby_name = Yii::$app->user->identity->userinfo->FIRST_M." ".Yii::$app->user->identity->userinfo->LAST_M;
            }
            
            $archiveHistory->remarks = "Report has been restored (system_generated_remarks)";
            $archiveHistory->status = $status_id;
            $archiveHistory->date_created = date("Y-m-d");
            $archiveHistory->time_created = date("h:i:sa");
            $archiveHistory->save();
        }
        

        GadRecord::updateAll(['is_archive' => 0],['id' => !empty($record_id) ? $record_id : $arrQue]);
        \Yii::$app->getSession()->setFlash('success', "Action has been performed");
        return $this->redirect(['index', 'report_type' => $report_type]);
    }

}
