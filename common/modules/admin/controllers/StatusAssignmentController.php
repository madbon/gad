<?php

namespace common\modules\admin\controllers;

use Yii;
use common\models\GadStatusAssignment;
use common\modules\admin\models\GadStatusAssignmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\AuthItem;

/**
 * StatusAssignmentController implements the CRUD actions for GadStatusAssignment model.
 */
class StatusAssignmentController extends Controller
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
     * Lists all GadStatusAssignment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GadStatusAssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GadStatusAssignment model.
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
     * Creates a new GadStatusAssignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GadStatusAssignment();
        $tags_status = ArrayHelper::map(\common\models\GadStatus::find()
            ->select(['code','CONCAT(code," - ",title," - ",future_tense) as title'])
            ->orderBy(['code' => SORT_ASC])
            ->all(), 'code', 'title');
        $auth_item = ArrayHelper::map(\common\models\AuthItem::find()->where(['type' => 1])->all(), 'name', 'name');

        if ($model->load(Yii::$app->request->post())) {
            $model->status = !empty($model->status) ? implode(",",$model->status) : null;
            $model->save();
            \Yii::$app->getSession()->setFlash('success', "Data has been saved");
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'tags_status' => $tags_status,
            'auth_item' => $auth_item
        ]);
    }

    /**
     * Updates an existing GadStatusAssignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $tags_status = ArrayHelper::map(\common\models\GadStatus::find()
            ->select(['code','CONCAT(code," - ",title," - ",future_tense) as title'])
            ->orderBy(['code' => SORT_ASC])
            ->all(), 'code', 'title');
        $auth_item = ArrayHelper::map(\common\models\AuthItem::find()->where(['type' => 1])->all(), 'name', 'name');
        $model->status = explode(",",$model->status);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = !empty($model->status) ? implode(",",$model->status) : null;
            $model->save();
            \Yii::$app->getSession()->setFlash('success', "Changes has been saved");
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'tags_status' => $tags_status,
            'auth_item' => $auth_item
        ]);
    }

    /**
     * Deletes an existing GadStatusAssignment model.
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
     * Finds the GadStatusAssignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GadStatusAssignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GadStatusAssignment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
