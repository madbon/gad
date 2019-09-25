<?php

namespace common\modules\report\controllers;

use Yii;
use common\models\GadRecord;
use common\models\GadReportHistory;
use common\modules\report\models\GadRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;
use yii\helpers\ArrayHelper;
use common\models\GadStatus;
use common\models\GadYear;
use niksko12\auditlogs\classes\ControllerAudit;
/**
 * GadRecordController implements the CRUD actions for GadRecord model.
 */
class GadRecordController extends ControllerAudit
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionTrack($ruc)
    {
        
        $qry = (new \yii\db\Query())
        ->select([
            'REG.abbreviation as region',
            'PRV.province_m as province',
            'CTC.citymun_m as citymun',
            'OFF.OFFICE_M as office',
            'HIS.fullname',
            'HIS.date_created',
            'HIS.time_created',
            'HIS.remarks',
            'HIS.status'
        ])
        ->from('gad_report_history HIS')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = HIS.responsible_region_c')
        ->leftJoin(['PRV' => 'tblprovince'], 'PRV.province_c = HIS.responsible_province_c')
        ->leftJoin(['OFF' => 'tbloffice'], 'OFF.OFFICE_C = HIS.responsible_office_c')
        ->leftJoin(['CTC' => 'tblcitymun'], 'CTC.citymun_c = HIS.responsible_citymun_c AND CTC.province_c = HIS.responsible_province_c')
        ->where(['HIS.tuc' => $ruc])
        ->groupBy(['HIS.id'])
        ->all();

        return $this->renderAjax('_track', [
            'qry' => $qry,
        ]);
    }

    public function GenerateRemarks($tuc)
    {
        $qryModel = \common\models\GadReportHistory::find()->where(['tuc' => $tuc])->orderBy(['id'=>SORT_DESC])->one();
        $value = !empty($qryModel->remarks) ? $qryModel->remarks : "";

        return $value;
    }

    public function GenerateLatestDate($tuc)
    {
        $qryModel = \common\models\GadReportHistory::find()->where(['tuc' => $tuc])->orderBy(['id'=>SORT_DESC])->one();
        

        return !empty($qryModel->date_created) ? date("F j, Y", strtotime(date($qryModel->date_created))) : "";
    }

    public function actionMultipleSubmit($report_type)
    {
        if($report_type == "plan_budget")
        {
            $reportValue = 1;
        }
        else
        {
            $reportValue = 2;
        }

        GadRecord::updateAll(['status' => 4],['status' => 3,'region_c' => Yii::$app->user->identity->userinfo->REGION_C,'report_type_id'=>$reportValue]);

        $qryThis = (new \yii\db\Query())
        ->select(["*"])
        ->from('gad_record REC')
        ->andWhere(['REC.status' => 3,'region_c' => Yii::$app->user->identity->userinfo->REGION_C])
        ->andWhere(['report_type_id' => $reportValue])
        ->groupBy(['REC.id'])
        ->all();

        $responsible_office_c = 0;
        if(Yii::$app->user->can("gad_region_permission"))
        {
            $responsible_office_c = 1;
        }
        else if(Yii::$app->user->can("gad_field_permission"))
        {
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS")
            {
                $responsible_office_c = 4;
            }
            else
            {
                $responsible_office_c = 3;
            }
        }

        $bulkInsertArray = array();
        foreach ($qryThis as $key => $row) {
            $bulkInsertArray[]=[
                'remarks' => 'Default remarks : Submitted to Central Office',
                'tuc'=>$row["tuc"],
                'status' => $row["status"],
                'responsible_office_c' => $responsible_office_c,
                'responsible_user_id' => Yii::$app->user->identity->id,
                'date_created' => date('Y-m-d'),
                'time_created' => date("h:i:sa"),
            ];
        }
        

        if(count($bulkInsertArray)>0){
            
            $columnNameArray=['remarks','tuc','status','responsible_office_c','responsible_user_id','date_created','time_created'];
            // below line insert all your record and return number of rows inserted
            $insertCount = Yii::$app->db->createCommand()
               ->batchInsert(
                     'gad_report_history', $columnNameArray, $bulkInsertArray
                 )
               ->execute();
        }

        \Yii::$app->getSession()->setFlash('success', "Action has been performed");
        return $this->redirect(['gad-record/index','report_type' => $report_type]);
    }

    /**
     * Lists all GadRecord models.
     * @return mixed
     */
    public function actionIndex($report_type)
    {
        $searchModel = new GadRecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $regionCondition = [];
        $provinceCondition = [];
        $citymunCondition = [];
        $statusCondition = [];
        $index_title = "";
        $urlReport = "";

        $firstYear = (int)date('Y') - 2;
        $lastYear = $firstYear + 1;
        $arrayYear = [];

        Yii::$app->session["activelink"] = $report_type;
        switch ($report_type) {
            case 'plan_budget':
                $dataProvider->query->andWhere(['GR.report_type_id' => 1]);
                $index_title = "List of GAD Plan and Budget";
                $urlReport = "gad-plan-budget/index";

            break;
            case 'accomplishment':
                $dataProvider->query->andWhere(['GR.report_type_id' => 2]);
                $index_title = "List of Accomplishment Report";
                $urlReport = "gad-accomplishment-report/index";
                
            break;
            
            default:
                throw new \yii\web\HttpException(404, 'The requested Page could not be found.');
            break;
        }

        if(Yii::$app->user->can("gad_lgu_permission")) // C/MLGOO
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $citymunCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C, 'citymun_c' => $searchModel->citymun_c  = Yii::$app->user->identity->userinfo->CITYMUN_C];

            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS")
            {
                $statusCondition = [3,6,8,10];
            }
            else
            {
                $statusCondition = [0,1,2,4,5,7];
            }
        }
        else if(Yii::$app->user->can("gad_region_permission")) // Regional Office
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $statusCondition = [3,6,8,9,10];

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
            $statusCondition = [0,1,2,4,5,7];
        } 
        else if(Yii::$app->user->can("gad_lgu_province_permission"))
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $citymunCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $statusCondition = [3,6,9,10];
        }
        else if(Yii::$app->user->can("gad_ppdo_permission"))
        {
            $regionCondition = ['region_c' => $searchModel->region_c = Yii::$app->user->identity->userinfo->REGION_C];
            $provinceCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $citymunCondition = ['province_c' => $searchModel->province_c  = Yii::$app->user->identity->userinfo->PROVINCE_C];
            $statusCondition = [0,1,2,4,5,7];
        }
        else if(Yii::$app->user->can("gad_central_permission") || Yii::$app->user->can("gad_admin_permission"))
        {
            $provinceCondition = ['region_c' => $searchModel->region_c];
            $citymunCondition = ['province_c' => $searchModel->province_c];
            $statusCondition = [0,1,2,3,4,5,6,7,8,9,10];
        }
        else
        {
            $provinceCondition = ['region_c' => $searchModel->region_c];
            $citymunCondition = ['province_c' => $searchModel->province_c];
            $statusCondition = [0,1,2,3,4,5,6,7,8,9,10];
        }

        $region = ArrayHelper::map(Region::find()->where($regionCondition)->all(), 'region_c', 'region_m');
        $province = ArrayHelper::map(Province::find()->where($provinceCondition)->all(), 'province_c', 'province_m');
        $citymun = ArrayHelper::map(Citymun::find()->where($citymunCondition)->all(), 'citymun_c', 'citymun_m');
        $statusList = ArrayHelper::map(GadStatus::find()->where(['code' => $statusCondition])->all(), 'code', 'title');
        $arrayYear = ArrayHelper::map(GadYear::find()->orderBy(['value' => SORT_DESC])->all(), 'value', 'value');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'index_title' => $index_title,
            'urlReport' => $urlReport,
            'report_type' =>  $report_type,
            'region' => $region,
            'province' => $province,
            'citymun' => $citymun,
            'statusList' => $statusList,
            'arrayYear' => $arrayYear
        ]);
    }

    /**
     * Displays a single GadRecord model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new GadRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($ruc,$onstep,$tocreate)
    {
        $model = new GadRecord();
        $model->region_c = Yii::$app->user->identity->userinfo->region->region_c;
        $model->province_c = Yii::$app->user->identity->userinfo->province->province_c;
        $create_plan_status = ArrayHelper::map(\common\models\CreateStatus::find()->all(), "code","title");
        Yii::$app->session["activelink"] = $tocreate;
        if(Yii::$app->user->can("gad_lgu_province_permission"))
        {
            $model->citymun_c = NULL;
            $model->isdilg = 0;
            $model->office_c = 2;
            $model->status = 9;
        }
        else if(Yii::$app->user->can("gad_lgu_permission"))
        {
            $model->citymun_c = Yii::$app->user->identity->userinfo->citymun->citymun_c;
            $model->isdilg = 0;
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS"){ 
                $model->office_c = 4; //city office
                $model->status = 8; // encoding HUC
            }
            else
            {
                $model->office_c = 3;
                $model->status = 0; // encoding non HUC
            }
        }
        
        $model->user_id = Yii::$app->user->identity->userinfo->user_id;
        date_default_timezone_set("Asia/Manila");
        $model->date_created = date('Y-m-d');
        $model->time_created = date("h:i:sa");
        $model->report_type_id = $tocreate == "gad_plan_budget" ? 1 : 2;
        $model->footer_date = date('Y-m-d');

        $modelUpdate = GadRecord::find()->where(['tuc' => $ruc])->one();
        if ($model->load(Yii::$app->request->post())) {
            if($onstep == "to_create_gpb")
            {
                $modelUpdate->total_lgu_budget = $model->total_lgu_budget;
                $modelUpdate->total_gad_budget = $model->total_gad_budget;
                $modelUpdate->year = $model->year;
                $modelUpdate->create_status_id = $model->create_status_id;
                $modelUpdate->for_revision_record_id = $model->for_revision_record_id;
                $modelUpdate->save();
            }
            else
            {

                $miliseconds = round(microtime(true) * 1000);
                $hash =  md5(date('Y-m-d')."-".date("h-i-sa")."-".$miliseconds);
                $model->tuc = $hash;
                $model->save();
            }

            $urlReportIndex = "";
            $onstepValue = "";
            if($tocreate == "accomp_report")
            {
                $urlReportIndex = '/report/gad-accomplishment-report/index';
                $onstepValue = "to_create_ar";
                Yii::$app->session["encode_gender_ar"] = "open";
                Yii::$app->session["encode_attribute_ar"] = "open";
            }
            else
            {
                $urlReportIndex = '/report/gad-plan-budget/index';
                $onstepValue = "to_create_gpb";
                Yii::$app->session["encode_gender_pb"] = "open";
                Yii::$app->session["encode_attribute_pb"] = "open";
            }
            
            // $ruc if back to step 1 use $ruc to update the record
            // $hash after saving record or the 1st step, this hash will be used to fill up report
            return $this->redirect([$urlReportIndex, 
                'ruc'       => $onstep == "to_create_gpb" ? $ruc : $hash,
                'onstep'    => $onstepValue,
                'tocreate'  => $tocreate,
            ]);
        }

        return $this->render('create', [
            // if onstep has this values just update record
            'model' => $onstep == "to_create_gpb" || $onstep == "to_create_ar" ? $modelUpdate : $model, 
            'ruc' =>  $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate,
            'create_plan_status' => $create_plan_status
        ]);
    }

    /**
     * Updates an existing GadRecord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GadRecord model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index','report_type' => 'plan_budget']);
    }

    /**
     * Finds the GadRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GadRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GadRecord::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
