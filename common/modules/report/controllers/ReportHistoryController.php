<?php

namespace common\modules\report\controllers;

use Yii;
use common\models\GadReportHistory;
use common\modules\report\models\GadReportHistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\modules\report\controllers\GadPlanBudgetController;
/**
 * ReportHistoryController implements the CRUD actions for GadReportHistory model.
 */
class ReportHistoryController extends Controller
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
     * Lists all GadReportHistory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GadReportHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GadReportHistory model.
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
     * Creates a new GadReportHistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($qryReportStatus,$ruc,$onstep,$tocreate)
    {
        $arrayRole = [];
        $arrayRole = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id));

        $model = new GadReportHistory();
        $model->tuc = $ruc;
        $model->status = $qryReportStatus;
        $qryAssignedStatus = \common\models\GadStatusAssignment::find()
        ->select(['status'])
        ->where(['status_code' => $qryReportStatus,'rbac_role' => $arrayRole])
        ->one();

        if(empty($qryAssignedStatus->status))
        {
            echo "No Available Action";
        }
        else
        {
            $arrStatusAssigned = explode(",",$qryAssignedStatus->status);
            $status = ArrayHelper::map(\common\models\GadStatus::find()->where(['code' => $arrStatusAssigned])->all(), "code","future_tense");

            date_default_timezone_set("Asia/Manila");
            $model->date_created = date('Y-m-d');
            $model->time_created = date("h:i:sa");
            $model->responsible_user_id = !empty(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : "";
            $model->responsible_region_c = !empty(Yii::$app->user->identity->userinfo->REGION_C) ? Yii::$app->user->identity->userinfo->REGION_C : "";
            $model->responsible_province_c = !empty(Yii::$app->user->identity->userinfo->PROVINCE_C) ? Yii::$app->user->identity->userinfo->PROVINCE_C : "";
            $model->responsible_citymun_c = !empty(Yii::$app->user->identity->userinfo->CITYMUN_C) ? Yii::$app->user->identity->userinfo->CITYMUN_C : "";
            $model->fullname = Yii::$app->user->identity->userinfo->FIRST_M." ".Yii::$app->user->identity->userinfo->LAST_M;
            $model->responsible_office_c = !empty(Yii::$app->user->identity->userinfo->OFFICE_C) ? Yii::$app->user->identity->userinfo->OFFICE_C : "";

            if ($model->load(Yii::$app->request->post())) {
                GadPlanBudgetController::ChangeReportStatus($model->status,$ruc);
                $model->save();
                \Yii::$app->getSession()->setFlash('success', "Action has been performed");
                if($tocreate == "accomp_report")
                {
                    return $this->redirect(['/report/gad-accomplishment-report/index', 'ruc' => $ruc,'onstep' => $onstep, 'tocreate' => $tocreate]);
                }
                else
                {
                    return $this->redirect(['/report/gad-plan-budget/index', 'ruc' => $ruc,'onstep' => $onstep, 'tocreate' => $tocreate]);
                }
            }

            return $this->renderAjax('create', [
                'model' => $model,
                'status' => $status
            ]);
        }   
    }

    /**
     * Updates an existing GadReportHistory model.
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
     * Deletes an existing GadReportHistory model.
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
     * Finds the GadReportHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GadReportHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GadReportHistory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
