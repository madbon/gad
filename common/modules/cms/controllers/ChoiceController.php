<?php

namespace common\modules\cms\controllers;

use Yii;
use common\modules\cms\models\Choice;
use common\modules\cms\models\ChoiceSearch;
use common\modules\cms\models\Indicator;
use common\modules\cms\models\DefaultChoice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ChoiceController implements the CRUD actions for Choice model.
 */
class ChoiceController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Choice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Choice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Choice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Choice();
        $indicator = ArrayHelper::map(Indicator::find()->all(), 'id', 'title');
        $default_choices = ArrayHelper::map(DefaultChoice::find()->all(), 'id', 'title');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'indicator' => $indicator,
                'default_choices' => $default_choices,
            ]);
        }
    }

    /**
     * Updates an existing Choice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $indicator = ArrayHelper::map(Indicator::find()->all(), 'id', 'title');
        $default_choices = ArrayHelper::map(DefaultChoice::find()->all(), 'id', 'title');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'indicator' => $indicator,
                'default_choices' => $default_choices,
            ]);
        }
    }

    /**
     * Deletes an existing Choice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Choice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Choice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Choice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
