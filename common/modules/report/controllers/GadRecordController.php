<?php

namespace common\modules\report\controllers;

use Yii;
use common\models\GadRecord;
use common\modules\report\models\GadRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GadRecordController implements the CRUD actions for GadRecord model.
 */
class GadRecordController extends Controller
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


    /**
     * Lists all GadRecord models.
     * @return mixed
     */
    public function actionIndex($report_type)
    {
        $searchModel = new GadRecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $index_title = "";
        $urlReport = "";

        switch ($report_type) {
            case 'plan_budget':
                $dataProvider->query->andWhere(['GR.report_type_id' => 1]);
                $index_title = "List of GAD Plan and Budget";
                $urlReport = "gad-plan-budget/index";
                Yii::$app->session["encode_gender_pb"] = "open";
                Yii::$app->session["encode_attribute_pb"] = "open";

            break;
            case 'accomplishment':
                $dataProvider->query->andWhere(['GR.report_type_id' => 2]);
                $index_title = "List of Accomplishment Report";
                $urlReport = "gad-accomplishment-report/index";
                Yii::$app->session["encode_gender_ar"] = "open";
                Yii::$app->session["encode_attribute_ar"] = "open";
            break;
            
            default:
                throw new \yii\web\HttpException(404, 'The requested Page could not be found.');
            break;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'index_title' => $index_title,
            'urlReport' => $urlReport,
            'report_type' =>  $report_type
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
        $model->citymun_c = Yii::$app->user->identity->userinfo->citymun->citymun_c;
        $model->user_id = Yii::$app->user->identity->userinfo->user_id;
        $model->status = 0;
        date_default_timezone_set("Asia/Manila");
        $model->date_created = date('Y-m-d');
        $model->time_created = date("h:i:sa");
        // print_r(Yii::$app->controller->id); exit;
        $model->report_type_id = $tocreate == "gad_plan_budget" ? 1 : 2;
        $model->footer_date = date('Y-m-d');

        $modelUpdate = GadRecord::find()->where(['tuc' => $ruc])->one();

        if ($model->load(Yii::$app->request->post())) {

            if($onstep == "to_create_gpb")
            {
                $modelUpdate->total_lgu_budget = $model->total_lgu_budget;
                $modelUpdate->total_gad_budget = $model->total_gad_budget;
                $modelUpdate->year = $model->year;
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
            }
            else
            {
                $urlReportIndex = '/report/gad-plan-budget/index';
                $onstepValue = "to_create_gpb";

            }
            
            // $ruc if back to step 1 use $ruc to update the record
            // $hash after saving record or the 1st step, this hash will be used to fill up report
            return $this->redirect([$urlReportIndex, 
                'ruc'       => $onstep == "to_create_gpb" ? $ruc : $hash,
                'onstep'    => $onstepValue,
                'tocreate'  => $tocreate]);
        }

        return $this->render('create', [
            // if onstep has this values just update record
            'model' => $onstep == "to_create_gpb" || $onstep == "to_create_ar" ? $modelUpdate : $model, 
            'ruc' =>  $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate
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

        return $this->redirect(['index']);
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
