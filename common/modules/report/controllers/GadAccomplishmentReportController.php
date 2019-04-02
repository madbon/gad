<?php

namespace common\modules\report\controllers;

use Yii;
use common\models\GadAccomplishmentReport;
use common\modules\report\models\GadAccomplishmentReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GadRecord;
use yii\helpers\ArrayHelper;

/**
 * GadAccomplishmentReportController implements the CRUD actions for GadAccomplishmentReport model.
 */
class GadAccomplishmentReportController extends Controller
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
     * Lists all GadAccomplishmentReport models.
     * @return mixed
     */
    public function actionIndex($ruc,$onstep,$tocreate)
    {
        // $dataRecord = GadRecord::find()->where(['tuc' => $ruc, 'report_type_id' => 2])->all();

        $qryRecord = (new \yii\db\Query())
        ->select([
            'REG.region_m as region_name',
            'PRV.province_m as province_name',
            'CTC.citymun_m as citymun_name',
            'GR.total_lgu_budget',
            'GR.total_gad_budget'
        ])
        ->from('gad_record GR')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = GR.region_c')
        ->leftJoin(['PRV' => 'tblprovince'], 'PRV.province_c = GR.province_c')
        ->leftJoin(['CTC' => 'tblcitymun'], 'CTC.citymun_c = GR.citymun_c AND CTC.province_c = GR.province_c')
        ->where(['GR.tuc' => $ruc])
        ->groupBy(['GR.id'])->one();
        $recRegion = !empty($qryRecord['region_name']) ? $qryRecord['region_name'] : "";
        $recProvince = !empty($qryRecord['province_name']) ? $qryRecord['province_name'] : "";
        $recCitymun = !empty($qryRecord['citymun_name']) ? $qryRecord['citymun_name'] : "";
        $recTotalLguBudget = !empty($qryRecord['total_lgu_budget']) ? $qryRecord['total_lgu_budget'] : "";
        $recTotalGadBudget = !empty($qryRecord['total_gad_budget']) ? $qryRecord['total_gad_budget'] : "";

        $dataAR = (new \yii\db\Query())
        ->select([
            'AR.id',
            'IF(AR.ppa_focused_id = 0, AR.ppa_value,CF.title) as ppa_value',
            'AR.cause_gender_issue',
            'AR.objective',
            'AR.relevant_lgu_ppa',
            'AR.activity',
            'AR.performance_indicator',
            'AR.target',
            'AR.actual_results',
            'AR.total_approved_gad_budget',
            'AR.actual_cost_expenditure',
            'AR.variance_remarks',
            'AR.record_tuc',
            'GF.title as gad_focused_title',
            'IC.title as inner_category_title',
            'GC.id as gad_focused_id',
            'IC.id as inner_category_id'
        ])
        ->from('gad_accomplishment_report AR')
        ->leftJoin(['CF' => 'gad_ppa_client_focused'], 'CF.id = AR.ppa_focused_id')
        ->leftJoin(['GC' => 'gad_comment'], 'GC.plan_budget_id = AR.id')
        ->leftJoin(['GF' => 'gad_focused'], 'GF.id = AR.focused_id')
        ->leftJoin(['IC' => 'gad_inner_category'], 'IC.id = AR.inner_category_id')
        ->where(['AR.record_tuc' => $ruc])
        ->orderBy(['AR.focused_id' => SORT_ASC,'AR.inner_category_id' => SORT_ASC,'AR.ppa_focused_id' => SORT_ASC,'AR.ppa_value' => SORT_ASC,'AR.id' => SORT_ASC])
        ->groupBy(['AR.focused_id','AR.inner_category_id','AR.ppa_focused_id','AR.ppa_value','AR.cause_gender_issue','AR.objective','AR.relevant_lgu_ppa','AR.activity','AR.performance_indicator','AR.target','AR.actual_results'])
        ->all();

        $select_GadFocused = ArrayHelper::map(\common\models\GadFocused::find()->all(), 'id', 'title');
        $select_GadInnerCategory = ArrayHelper::map(\common\models\GadInnerCategory::find()->all(), 'id', 'title');
        $select_PpaAttributedProgram = ArrayHelper::map(\common\models\GadPpaAttributedProgram::find()->all(), 'id', 'title');

        return $this->render('index', [
            'select_GadFocused' => $select_GadFocused,
            'select_GadInnerCategory' => $select_GadInnerCategory,
            'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
            // 'dataRecord' => $dataRecord,
            'dataAR' => $dataAR,
            'recRegion' => $recRegion,
            'recProvince' => $recProvince,
            'recCitymun' => $recCitymun,
            'recTotalGadBudget' => $recTotalGadBudget,
            'recTotalLguBudget' => $recTotalLguBudget,
            'ruc' => $ruc,
            'onstep' => $onstep
        ]);
    }

    /**
     * Displays a single GadAccomplishmentReport model.
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
     * Creates a new GadAccomplishmentReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GadAccomplishmentReport();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GadAccomplishmentReport model.
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
     * Deletes an existing GadAccomplishmentReport model.
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
     * Finds the GadAccomplishmentReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GadAccomplishmentReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GadAccomplishmentReport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
