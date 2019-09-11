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

        $condition_rec_status = [];
        $andFilterValue = [];
        $groupByValue = ['REC.status'];

        if(Yii::$app->user->can('gad_ppdo_permission'))
        {
            $condition_rec_status = [0,1,2,5,7,4];
            $andFilterWhere = ['REC.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C];
            $groupByValue = ['REC.status','CIT.citymun_m'];
        }
        else if(Yii::$app->user->can('gad_province_permission'))
        {
            $condition_rec_status = [0,1,2,5,7,4];
            $andFilterValue = ['REC.province_c' => Yii::$app->user->identity->userinfo->PROVINCE_C];
            $groupByValue = ['REC.status','CIT.citymun_m'];
        }
        else if(Yii::$app->user->can('gad_region_permission'))
        {
            $condition_rec_status = [3,6,8,9,10];
            $andFilterValue = ['REC.region_c' => Yii::$app->user->identity->userinfo->REGION_C];
            $groupByValue = ['REC.status','REC.province_c'];
        }
        else
        {
            $condition_rec_status = [0,1,2,3,4,5,6,7,8,9,10];
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
        ->andWhere(['REC.status' => $condition_rec_status])
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
        ->andWhere(['REC.status' => $condition_rec_status])
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

}
