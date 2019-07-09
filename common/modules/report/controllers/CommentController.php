<?php

namespace common\modules\report\controllers;

use Yii;
use common\models\GadComment;
use common\modules\report\models\GadCommentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentController implements the CRUD actions for GadComment model.
 */
class CommentController extends Controller
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

    public function actionLoadComment($plan_budget_id)
    {
        $qry = (new \yii\db\Query())
        ->select([
            'GC.id as comment_id',
            'GC.comment as comment_value',
            'REG.region_m as region_name',
            'PRV.province_m as province_name',
            'CTC.citymun_m as citymun_name',
            'GC.resp_user_id as user_id',
            'GC.date_created',
            'GC.time_created',
            'CONCAT(UI.FIRST_M," ",UI.LAST_M) as full_name',
            'OFC.OFFICE_M as office_name',
            'GC.row_value',
            'GC.row_no',
            'GC.column_no',
            'GC.column_title',
            'GC.column_value'
        ])
        ->from('gad_comment GC')
        ->leftJoin(['UI' => 'user_info'], 'UI.user_id = GC.resp_user_id')
        ->leftJoin(['OFC' => 'tbloffice'], 'OFC.OFFICE_C = GC.resp_office_c')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = GC.resp_region_c')
        ->leftJoin(['PRV' => 'tblprovince'], 'PRV.province_c = GC.resp_province_c')
        ->leftJoin(['CTC' => 'tblcitymun'], 'CTC.citymun_c = GC.resp_citymun_c AND CTC.province_c = GC.resp_province_c')
        // ->where(['GC.record_id' => $record_id])
        ->groupBy(['GC.id'])
        ->orderBy(['GC.id' => SORT_DESC])
        ->all();
        // ->createCommand()->rawSql;
        // $qry = GadComment::find()->select(["id","comment"])->where(["plan_budget_id" => $id, "attribute_name" => $attribute])->orderBy(["id" => SORT_DESC])->all();
        // print_r($qry); exit;
        $arr = [];
        foreach ($qry as  $item) {
            $arr[] = [
                        'comment_id' => $item["comment_id"],
                        'comment' => $item["comment_value"],
                        'region_name' => $item["region_name"],
                        'province_name' => $item["province_name"],
                        'citymun_name' => $item["citymun_name"],
                        'date_created' => date("F j, Y", strtotime($item["date_created"])),
                        'time_created' => $item["time_created"],
                        'full_name' => $item["full_name"],
                        'office_name' => $item["office_name"],
                        'user_id_comment' => $item["user_id"],
                        'column_no' => $item["column_no"],
                        'column_value' => $item["column_value"],
                        'row_no' => $item["row_no"],
                        'row_value' => $item["row_value"],
                     ];
        }
        
        \Yii::$app->response->format = 'json';
        return $arr;
    }

    /**
     * Lists all GadComment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GadCommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GadComment model.
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
     * Creates a new GadComment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($plan_id,$row_no,$column_no,$attribute_name,$column_title)
    {
        $model = new GadComment();
        $searchModel = new GadCommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model->row_no = $row_no;
        $model->column_no = $column_no;
        $model->attribute_name = $attribute_name;
        $model->plan_budget_id = $plan_id;
        $model->column_title = $column_title;

        $qry = \common\models\GadPlanBudget::find()->where(['id' => $plan_id])->one();
        $project_title = !empty($qry->ppa_value) ? $qry->ppa_value : "";

        // print_r($attribute_name); exit;
        if($attribute_name == "ppa_value")
        {
            $row_value = !empty($qry->ppa_value) ? $qry->ppa_value : "";
        }
        else if($attribute_name == "objective")
        {
            $row_value = !empty($qry->objective) ? $qry->objective : "";
        }
        else if($attribute_name == "relevant_lgu_program_project")
        {
            $row_value = !empty($qry->relevant_lgu_program_project) ? $qry->relevant_lgu_program_project : "";
        }
        else if($attribute_name == "activity")
        {
            $row_value = !empty($qry->activity) ? $qry->activity : "";
        }
        else if($attribute_name == "performance_target")
        {
            $row_value = !empty($qry->performance_target) ? $qry->performance_target : "";
        }
        else if($attribute_name == "budget_co")
        {
            $row_value = !empty($qry->budget_co) ? $qry->budget_co : "";
        }
        else if($attribute_name == "budget_ps")
        {
            $row_value = !empty($qry->budget_ps) ? $qry->budget_ps : "";
        }
        else if($attribute_name == "budget_mooe")
        {
            $row_value = !empty($qry->budget_mooe) ? $qry->budget_mooe : "";
        }
        else if($attribute_name == "lead_responsible_office")
        {
            $row_value = !empty($qry->lead_responsible_office) ? $qry->lead_responsible_office : "";
        }
        else
        {
            $row_value = "";
        }
        
        $model->row_value = $project_title;
        $model->column_value = $row_value;

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }

        return $this->renderAjax('create', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new GadComment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateComment($row_no,$row_value,$column_no,$column_value,$attribute_name,$comment,$plan_budget_id,$column_title)
    {
        $model = new GadComment();

        $model->row_no = $row_no;
        $model->column_no = $column_no;
        $model->attribute_name = $attribute_name;
        $model->plan_budget_id = $plan_budget_id;
        $model->comment = $comment;
        $model->column_title = $column_title;

        $qry = \common\models\GadPlanBudget::find()->where(['id' => $plan_budget_id])->one();

        $project_title = !empty($qry->ppa_value) ? $qry->ppa_value : "";
        $model->row_value = $project_title;
        $model->column_value = $column_value;

        $model->record_id = $qry->record_id;
        $model->resp_user_id = Yii::$app->user->identity->id;
        $model->resp_office_c = !empty(Yii::$app->user->identity->userinfo->OFFICE_C) ? Yii::$app->user->identity->userinfo->OFFICE_C : "";
        $model->resp_region_c = !empty(Yii::$app->user->identity->userinfo->REGION_C) ? Yii::$app->user->identity->userinfo->REGION_C : "";
        $model->resp_province_c = !empty(Yii::$app->user->identity->userinfo->PROVINCE_C) ? Yii::$app->user->identity->userinfo->PROVINCE_C : "";
        $model->resp_citymun_c = !empty(Yii::$app->user->identity->userinfo->CITYMUN_C) ? Yii::$app->user->identity->userinfo->CITYMUN_C : "";
        $model->focused_id = $qry->focused_id;
        $model->inner_category_id = $qry->inner_category_id;
        $model->model_name = "GadPlanBudget";

        if(!$model->save())
        {
            print_r($model->errors); exit;
        }

        
    }

    /**
     * Updates an existing GadComment model.
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
     * Deletes an existing GadComment model.
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
     * Finds the GadComment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GadComment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GadComment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
