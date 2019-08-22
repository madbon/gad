<?php

namespace common\modules\cms\controllers;

use Yii;
use common\models\GadCategoryComment;
use common\modules\cms\models\GadCategoryCommentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryCommentController implements the CRUD actions for GadCategoryComment model.
 */
class CategoryCommentController extends Controller
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
     * Lists all GadCategoryComment models.
     * @return mixed
     */
    public function actionIndex($ruc)
    {
        $searchModel = new GadCategoryCommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new GadCategoryComment();

        $Record = \common\models\GadRecord::find()->where(['tuc' => $ruc])->one();

        $queryValues = (new \yii\db\Query())
        ->select([
            'IND.title as indicator_title',
            'VAL.value',
            'CAT.title as category_title',
            'CAT.id as category_id',
            'REC.id as record_id'
        ])
        ->from('gad_cms_values VAL')
        ->leftJoin(['REC' => 'gad_record'], 'REC.id = VAL.yearly_record_id')
        ->leftJoin(['IND' => 'gad_cms_indicator'], 'IND.id = VAL.indicator_id')
        ->leftJoin(['CAT' => 'gad_cms_category'], 'CAT.id = IND.category_id')
        ->where(['REC.tuc' => $ruc]);

        $postquery = $queryValues->one();
        $dataProvider->query->andWhere(['record_id' => $postquery["record_id"]]);

        if ($model->load(Yii::$app->request->post())) {
            
            
            $model->category_id = $postquery["category_id"];
            $model->record_id = $postquery["record_id"];
            $model->save();
            return $this->redirect(['index','ruc' => $ruc]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'queryValues' => $queryValues->all(),
            'ruc' => $ruc,
            'category_id' => $postquery['category_id'],
        ]);
    }

    /**
     * Displays a single GadCategoryComment model.
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
     * Creates a new GadCategoryComment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GadCategoryComment();
        // exit;
        if ($model->load(Yii::$app->request->post())) {
            // print_r($model->errors); exit;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GadCategoryComment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$ruc)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'ruc' => $ruc]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GadCategoryComment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$ruc)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index','ruc' => $ruc]);
    }

    /**
     * Finds the GadCategoryComment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GadCategoryComment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GadCategoryComment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
