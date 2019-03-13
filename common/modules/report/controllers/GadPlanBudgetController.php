<?php

namespace common\modules\report\controllers;

use Yii;
use common\models\GadPlanBudget;
use common\models\GadPlanBudgetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use niksko12\user\models\UserInfo;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;
use yii\helpers\ArrayHelper;

/**
 * GadPlanBudgetController implements the CRUD actions for GadPlanBudget model.
 */
class GadPlanBudgetController extends Controller
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
     * Lists all GadPlanBudget models.
     * @return mixed
     */
    public function actionIndex($ruc)
    {
        $dataRecord = \common\models\GadRecord::find()->where(['tuc' => $ruc])->all();
        // $dataFocusedId = (new \yii\db\Query())
        // ->select([
        //     'PB.id',
        //     'IF(PB.ppa_focused_id = 0, PB.ppa_value,CF.title) as ppa_value',
        //     'PB.cause_gender_issue',
        //     'PB.objective',
        //     'PB.relevant_lgu_program_project',
        //     'PB.activity',
        //     'PB.performance_target'
        // ])
        // ->from('gad_plan_budget PB')
        // ->leftJoin(['CF' => 'gad_ppa_client_focused'], 'CF.id = PB.ppa_focused_id')
        // ->groupBy(['PB.ppa_focused_id','PB.cause_gender_issue','PB.objective','PB.relevant_lgu_program_project','PB.activity','PB.performance_target'])
        // ->where(['PB.record_tuc' => $ruc])
        // ->orderBy(['PB.ppa_focused_id' => SORT_ASC,'PB.cause_gender_issue' => SORT_ASC])->all();
        // $dataPlanBudget = GadPlanBudget::find()
        // ->groupBy(['ppa_value','cause_gender_issue','objective','relevant_lgu_program_project','activity','performance_target'])
        // ->where(['record_tuc' => $ruc])
        // ->orderBy(['ppa_value' => SORT_ASC,'cause_gender_issue' => SORT_ASC])->all();

        $dataPlanBudget = (new \yii\db\Query())
        ->select([
            'PB.id',
            'IF(PB.ppa_focused_id = 0, PB.ppa_value,CF.title) as ppa_value',
            'PB.cause_gender_issue',
            'PB.objective',
            'PB.relevant_lgu_program_project',
            'PB.activity',
            'PB.performance_target',
            'PB.performance_indicator',
            'PB.budget_mooe',
            'PB.budget_ps',
            'PB.budget_co',
            'PB.lead_responsible_office'
        ])
        ->from('gad_plan_budget PB')
        ->leftJoin(['CF' => 'gad_ppa_client_focused'], 'CF.id = PB.ppa_focused_id')
        ->groupBy(['PB.ppa_focused_id','PB.cause_gender_issue','PB.objective','PB.relevant_lgu_program_project','PB.activity','PB.performance_target'])
        ->where(['PB.record_tuc' => $ruc])
        ->orderBy(['PB.ppa_focused_id' => SORT_ASC,'PB.cause_gender_issue' => SORT_ASC])->all();
        // echo "<pre>";
        // print_r($dataPlanBudget); exit;

        $objective_type = ArrayHelper::getColumn(GadPlanBudget::find()->select(['objective'])->distinct()->all(), 'objective');
        $relevant_type       = ArrayHelper::getColumn(GadPlanBudget::find()
                            ->select(['relevant_lgu_program_project'])
                            ->distinct()
                            ->all(), 'relevant_lgu_program_project');
        $opt_org_focused = ArrayHelper::map(\common\models\GadPpaOrganizationalFocused::find()->all(), 'id', 'title');
        $opt_cli_focused = ArrayHelper::map(\common\models\GadPpaClientFocused::find()->all(), 'id', 'title');
        return $this->render('index', [
            'dataRecord' => $dataRecord,
            'dataPlanBudget' => $dataPlanBudget,
            'ruc' => $ruc,
            'objective_type' => $objective_type,
            'opt_org_focused' => $opt_org_focused,
            'opt_cli_focused' => $opt_cli_focused,
            'relevant_type' => $relevant_type,
        ]);
    }

    /**
     * Displays a single GadPlanBudget model.
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
     * Creates a new GadPlanBudget model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GadPlanBudget();
        $region = ArrayHelper::map(Region::find()->all(), 'region_c', 'region_m');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'region' => $region,
        ]);
    }

    /**
     * Updates an existing GadPlanBudget model.
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
     * Deletes an existing GadPlanBudget model.
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
     * Finds the GadPlanBudget model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GadPlanBudget the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GadPlanBudget::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
