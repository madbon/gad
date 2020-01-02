<?php

namespace common\modules\report\controllers;
use common\models\GadStatus;
use common\models\GadStatusAssignment;
use common\models\GadRecord;
use Yii;
use niksko12\auditlogs\classes\ControllerAudit;
use common\modules\report\controllers\DefaultController;

class DashboardController extends ControllerAudit
{
    public function actionIndex()
    {
    	Yii::$app->session["activelink"] = "dashboard";

        $condition_rec_status = [];
        $andFilterValue = [];
        $groupByValue = ['REC.status'];

        if(Yii::$app->user->can('gad_ppdo_permission'))
        {
            $condition_rec_status = DefaultController::ViewStatus("gad_ppdo");
            $andFilterValue = ['REC.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C];
            $groupByValue = ['REC.status','CIT.citymun_m'];
        }
        else if(Yii::$app->user->can('gad_province_permission')) // dilg province
        {
            $condition_rec_status = DefaultController::ViewStatus("gad_province_dilg");
            $andFilterValue = ['REC.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C];
            $groupByValue = ['REC.status','CIT.citymun_m'];
        }
        else if(Yii::$app->user->can('gad_region_permission'))
        {
            $condition_rec_status = DefaultController::ViewStatus("gad_region_dilg");
            $andFilterValue = ['REC.region_c' => Yii::$app->user->identity->userinfo->REGION_C];
            $groupByValue = ['REC.status','REC.province_c'];
        }
        else
        {
            $condition_rec_status = DefaultController::ViewStatus("gad_all_status");
            $andFilterValue = [];
            $groupByValue = ['REC.status','REC.region_c'];
        }

    	$queryChart = (new \yii\db\Query())
        ->select([
        	'COUNT(REC.id) as count_status',
        	'STAT.title as status_name',
        	'STAT.code as status_code',
        	'REG.region_m as region_name',
        	'REG.region_c as region_code',
            'CIT.citymun_m as citymun_name',
            'PROV.province_m as province_name'
        	// 'PROV.province_m as province_name',
        	// 'PROV.province_c as province_code',
        	// 'CIT.citymun_m as citymun_name',
        	// 'CIT.citymun_c as citymun_code'
        ])
        ->from('gad_status STAT')
        ->leftJoin(['REC' => 'gad_record'], 'REC.status = STAT.code')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = REC.region_c')
        ->leftJoin(['PROV' => 'tblprovince'], 'PROV.province_c = REC.province_c')
        ->leftJoin(['CIT' => 'tblcitymun'], 'CIT.citymun_c = REC.citymun_c AND CIT.province_c = REC.province_c')
        ->andWhere(['REC.status' => $condition_rec_status, 'REC.is_archive' => 0])
        ->andFilterWhere($andFilterValue)
        ->groupBy(['STAT.code'])
        ->orderBy(['STAT.code' => SORT_ASC])
        ->all();

        $category_status = [];
        foreach ($queryChart as $key => $row) {
            $category_status[] = $row['status_name'];
        }

        $count_status = [];
        $status_count = [];
        foreach ($queryChart as $key1 => $row1) {
            $status_count[] = (int)$row1['count_status'];
        }

        // $data_status = [];
        // $product_status = [];
        $data_status = ['name'=>'Total Percentage', 'type'=>'column','data' => $status_count];
        $product_status = [0 => $data_status];

        // tables

        $queryTable = (new \yii\db\Query())
        ->select([
            'COUNT(REC.id) as count_status',
            'STAT.title as status_name',
            'STAT.code as status_code',
            'REG.region_m as region_name',
            'REG.region_c as region_code',
            'CIT.citymun_m as citymun_name',
            'PROV.province_m as province_name'
            // 'PROV.province_m as province_name',
            // 'PROV.province_c as province_code',
            // 'CIT.citymun_m as citymun_name',
            // 'CIT.citymun_c as citymun_code'
        ])
        ->from('gad_status STAT')
        ->leftJoin(['REC' => 'gad_record'], 'REC.status = STAT.code')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = REC.region_c')
        ->leftJoin(['PROV' => 'tblprovince'], 'PROV.province_c = REC.province_c')
        ->leftJoin(['CIT' => 'tblcitymun'], 'CIT.citymun_c = REC.citymun_c AND CIT.province_c = REC.province_c')
        ->andWhere(['REC.status' => $condition_rec_status, 'REC.is_archive' => 0])
        ->andFilterWhere($andFilterValue)
        ->groupBy($groupByValue)
        ->orderBy(['STAT.code' => SORT_ASC])
        ->all();
        // ;

        // print_r($queryTable->createCommand()->rawSql); exit;

        return $this->render('index',
            [
                'category_status' => $category_status,
                'product_status' => $product_status,
                'queryTable' => $queryTable
            ]
        );
    }

    public function actionView()
    {
        $role = [];
        $rbac_role = [];
        
        if(Yii::$app->user->can("gad_lgu_permission"))
        {
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS")
            {
                $rbac_role = ["gad_lgu"];
                $role = ["gad_lgu_huc"];
            }
            else
            {
                $rbac_role = ["gad_lgu"];
                $role = ["gad_lgu_non_huc"];
            }
        }
        else if(Yii::$app->user->can("gad_field_permission"))
        {
            $rbac_role = ["gad_lgu"];
            $role = ["gad_lgu_non_huc","gad_lgu_huc"];
        }
        else if(Yii::$app->user->can("gad_province_permission")) // all lower level lgu under its province
        {
            $rbac_role = ["gad_lgu_province"];
            $role = ["gad_province_dilg"];
        }
        else if(Yii::$app->user->can("gad_lgu_province_permission")) // all plan submitted by this province
        {
            $rbac_role = ["gad_lgu_province"];
            $role = ["gad_province_lgu"];
        }
        else if(Yii::$app->user->can("gad_region_permission"))
        {
            $rbac_role = ["gad_region"];
            $role = ["gad_region_dilg"];
        }
        else if(Yii::$app->user->can("gad_ppdo_permission"))
        {
            $rbac_role = ["gad_ppdo"];
            $role = ["gad_ppdo"];
        }
        else
        {
            $rbac_role = [""];
            $role = ["gad_all_status"];
        }

        $query = GadStatusAssignment::find()
        ->select(['status'])
        ->where(['role' => $role])
        ->andFilterWhere(['rbac_role' => $rbac_role])
        ->one();
        // ->createCommand()->rawSql;
        // print_r($query); exit;

        $status = !empty($query->status) ? $query->status : "";
        return $this->render('view',
            [
                'status' => $status,
            ]
        );
    }

}
