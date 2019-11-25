<?php

namespace common\modules\report\controllers;

use Yii;
use common\models\GadComment;
use common\modules\report\models\GadCommentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\modules\report\controllers\DefaultController;
use niksko12\auditlogs\classes\ControllerAudit;
/**
 * CommentController implements the CRUD actions for GadComment model.
 */
class CommentController extends ControllerAudit
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

    public function actionLoadComment($record_tuc)
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
        ->leftJoin(['REC' => 'gad_record'], 'REC.id = GC.record_id')
        ->leftJoin(['OFC' => 'tbloffice'], 'OFC.OFFICE_C = GC.resp_office_c')
        ->leftJoin(['REG' => 'tblregion'], 'REG.region_c = GC.resp_region_c')
        ->leftJoin(['PRV' => 'tblprovince'], 'PRV.province_c = GC.resp_province_c')
        ->leftJoin(['CTC' => 'tblcitymun'], 'CTC.citymun_c = GC.resp_citymun_c AND CTC.province_c = GC.resp_province_c')
        ->where(['REC.tuc' => $record_tuc, 'GC.resp_user_id' => Yii::$app->user->identity->id])
        ->groupBy(['GC.id'])
        ->orderBy(['GC.id' => SORT_ASC])
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
                        'column_title' => $item["column_title"]
                     ];
        }
        
        \Yii::$app->response->format = 'json';
        return $arr;
    }

    public function actionEditComment($comment_id)
    {
        $qry = GadComment::find()->where(['id' => $comment_id])->one();

        $arr = [
            'row_no' => $qry->row_no,
            'column_no' => $qry->column_no,
            'column_title' => $qry->column_title,
            'row_value' => $qry->row_value,
            'column_value' => $qry->column_value,
            'comment' => $qry->comment,
            'plan_budget_id' => $qry->plan_budget_id,
            'attribute_name' => $qry->attribute_name,
            'record_id' => $qry->record_id,
            'id' => $qry->id
        ];

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
    public function actionCreate($plan_id,$row_no,$column_no,$attribute_name,$column_title,$ruc,$controllerid)
    {
        $model = new GadComment();
        $searchModel = new GadCommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model->row_no = $row_no;
        $model->column_no = $column_no;
        $model->attribute_name = $attribute_name;
        $model->plan_budget_id = $plan_id;
        $model->column_title = $column_title;
        $model->record_tuc = $ruc;

        $qry = \common\models\GadPlanBudget::find()->where(['id' => $plan_id])->one();
        $qryAttributed = \common\models\GadAttributedProgram::find()->where(['id' => $plan_id])->one();

        if($controllerid == "GadPlanBudget")
        {
            $model->row_value = !empty($qry->ppa_value) ? $qry->ppa_value : "";
        }
        else if($controllerid == "GadAttributedProgram")
        {
            $model->row_value = !empty($qryAttributed->lgu_program_project) ? $qryAttributed->lgu_program_project : "";
        }

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
        else if($attribute_name == "lgu_program_project")
        {
            $row_value = !empty($qryAttributed->lgu_program_project) ? $qryAttributed->lgu_program_project : "";
        }
        else if($attribute_name == "hgdg")
        {

            $row_value = !empty($qryAttributed->hgdg) ? $qryAttributed->hgdg : "";
        }
        else if($attribute_name == "total_annual_pro_budget")
        {
            $row_value = !empty($qryAttributed->total_annual_pro_budget) ? $qryAttributed->total_annual_pro_budget : "";
        }
        else if($attribute_name == "ap_lead_responsible_office")
        {
            $row_value = !empty($qryAttributed->ap_lead_responsible_office) ? $qryAttributed->ap_lead_responsible_office : "";
        }
        else
        {
            $row_value = "";
        }
        
        // $model->row_value = $project_title;
        $model->column_value = $row_value;

        $model->model_name = $controllerid;

        return $this->renderAjax('create', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ruc' => $ruc,
            'controllerid' => $controllerid
        ]);
    }

    /**
     * Creates a new GadComment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateComment()
    {

        $model = new GadComment();

        $arrVal = Yii::$app->request->post();

        $row_no = $arrVal["row_no"];
        $row_value = $arrVal["row_value"];
        $column_no = $arrVal["column_no"];
        $column_value = $arrVal["column_value"];
        $attribute_name = $arrVal["attribute_name"];
        $comment = $arrVal["comment"];
        $plan_budget_id = $arrVal["plan_budget_id"];
        $column_title = $arrVal["column_title"];
        $ruc = $arrVal["ruc"];
        $model_name = $arrVal["model_name"];

        $model->row_no = $row_no;
        $model->column_no = $column_no;
        $model->attribute_name = $attribute_name;
        $model->plan_budget_id = $plan_budget_id;
        $model->comment = $comment;
        $model->column_title = $column_title;

        date_default_timezone_set("Asia/Manila");
        $model->date_created = date('Y-m-d');
        $model->time_created = date("h:i:sa");

        $qry = \common\models\GadPlanBudget::find()->where(['id' => $plan_budget_id])->one();

        $project_title = !empty($qry->ppa_value) ? $qry->ppa_value : "";

        $qryAttributed = \common\models\GadAttributedProgram::find()->where(['id' => $plan_budget_id])->one();
        if($project_title == "")
        {
            $project_title = !empty($qryAttributed->lgu_program_project) ? $qryAttributed->lgu_program_project : "";
        }

        $model->row_value = $project_title;
        $model->column_value = $column_value;

        $model->record_id = DefaultController::GetRecordIdByRuc($ruc);
        $model->resp_user_id = Yii::$app->user->identity->id;
        $model->resp_office_c = !empty(Yii::$app->user->identity->userinfo->OFFICE_C) ? Yii::$app->user->identity->userinfo->OFFICE_C : "";
        $model->resp_region_c = !empty(Yii::$app->user->identity->userinfo->REGION_C) ? Yii::$app->user->identity->userinfo->REGION_C : "";
        $model->resp_province_c = !empty(Yii::$app->user->identity->userinfo->PROVINCE_C) ? Yii::$app->user->identity->userinfo->PROVINCE_C : "";
        $model->resp_citymun_c = !empty(Yii::$app->user->identity->userinfo->CITYMUN_C) ? Yii::$app->user->identity->userinfo->CITYMUN_C : "";

        
        $model->model_name = $model_name;

        if(!$model->save())
        {
            print_r($model->error); exit;
        }

        
    }

    /**
     * Updates an existing GadComment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateComment()
    {
        $arrVal = Yii::$app->request->post();
        $qry = GadComment::find()->where(['id' => $arrVal['id']])->one();
        $qry->comment = $arrVal["comment"];
        date_default_timezone_set("Asia/Manila");
        $qry->date_updated = date('Y-m-d');
        $qry->time_updated = date("h:i:sa");
        $qry->save(false);
    }

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

    public function actionDeleteComment($comment_id)
    {
        $this->findModel($comment_id)->delete();
    }

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
