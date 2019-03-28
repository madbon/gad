<?php

namespace common\modules\report\controllers;

use Yii;
use common\models\GadPpaAttributedProgram;
use common\models\GadFocused;
use common\models\GadInnerCategory;
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
    public function actionIndex($ruc,$onstep)
    {
        $dataAttributedProgram = (new \yii\db\Query())
        ->select([
            'AP.id',
            'IF(AP.ppa_attributed_program_id = 0, AP.ppa_attributed_program_others, PAP.title) as ap_ppa_value',
            'AP.lgu_program_project',
            'AP.hgdg',
            'AP.total_annual_pro_budget',
            'AP.attributed_pro_budget',
            'AP.lead_responsible_office',
            'AP.record_tuc',
            'AP.controller_id'
        ])
        ->from('gad_attributed_program AP')
        ->leftJoin(['PAP' => 'gad_ppa_attributed_program'], 'PAP.id = AP.ppa_attributed_program_id')
        ->where(['AP.record_tuc' => $ruc])
        ->groupBy(['AP.ppa_attributed_program_id','AP.ppa_attributed_program_others','AP.lgu_program_project'])
        ->orderBy(['AP.ppa_attributed_program_id' => SORT_ASC, 'AP.ppa_attributed_program_id' => SORT_ASC,'AP.ppa_attributed_program_others' => SORT_ASC,'AP.id' => SORT_ASC,'AP.lgu_program_project' => SORT_ASC])
        ->all();

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
            'PB.lead_responsible_office',
            'COUNT(GC.plan_budget_id) as count_comment',
            'GC.attribute_name as attr_name',
            'PB.record_tuc as record_uc',
            'GF.title as gad_focused_title',
            'IC.title as inner_category_title',
            'PB.focused_id'
        ])
        ->from('gad_plan_budget PB')
        ->leftJoin(['CF' => 'gad_ppa_client_focused'], 'CF.id = PB.ppa_focused_id')
        ->leftJoin(['GC' => 'gad_comment'], 'GC.plan_budget_id = PB.id')
        ->leftJoin(['GF' => 'gad_focused'], 'GF.id = PB.focused_id')
        ->leftJoin(['IC' => 'gad_inner_category'], 'IC.id = PB.inner_category_id')
        ->where(['PB.record_tuc' => $ruc])
        ->orderBy(['PB.focused_id' => SORT_ASC,'PB.inner_category_id' => SORT_ASC,'PB.ppa_focused_id' => SORT_ASC,'PB.ppa_value' => SORT_ASC,'PB.id' => SORT_ASC])
        ->groupBy(['PB.focused_id','PB.inner_category_id','PB.ppa_focused_id','PB.ppa_value','PB.cause_gender_issue','PB.objective','PB.relevant_lgu_program_project','PB.activity','PB.performance_target'])
        ->all();
        // echo "<pre>";
        // print_r($dataPlanBudget); exit;

        $objective_type = ArrayHelper::getColumn(GadPlanBudget::find()->select(['objective'])->distinct()->all(), 'objective');
        $relevant_type       = ArrayHelper::getColumn(GadPlanBudget::find()
                            ->select(['relevant_lgu_program_project'])
                            ->distinct()
                            ->all(), 'relevant_lgu_program_project');
        $opt_org_focused = ArrayHelper::map(\common\models\GadPpaOrganizationalFocused::find()->all(), 'id', 'title');
        $opt_cli_focused = ArrayHelper::map(\common\models\GadPpaClientFocused::find()->all(), 'id', 'title');

        $select_GadFocused = ArrayHelper::map(GadFocused::find()->all(), 'id', 'title');
        $select_GadInnerCategory = ArrayHelper::map(GadInnerCategory::find()->all(), 'id', 'title');
        $select_PpaAttributedProgram = ArrayHelper::map(GadPpaAttributedProgram::find()->all(), 'id', 'title');


        if($onstep == "to_create_gpb")
        {
            $renderValue = 'step_create_gpb';
        }
        else
        {
            $renderValue = 'index';
        }

        return $this->render($renderValue, [
            'dataAttributedProgram' => $dataAttributedProgram,
            'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
            'dataPlanBudget' => $dataPlanBudget,
            'ruc' => $ruc,
            'objective_type' => $objective_type,
            'opt_org_focused' => $opt_org_focused,
            'opt_cli_focused' => $opt_cli_focused,
            'relevant_type' => $relevant_type,
            'recRegion' => $recRegion,
            'recProvince' => $recProvince,
            'recCitymun' => $recCitymun,
            'recTotalGadBudget' => $recTotalGadBudget,
            'recTotalLguBudget' => $recTotalLguBudget,
            'onstep' => $onstep,
            'select_GadFocused' => $select_GadFocused,
            'select_GadInnerCategory' => $select_GadInnerCategory,
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
