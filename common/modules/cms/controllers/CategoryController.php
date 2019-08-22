<?php

namespace common\modules\cms\controllers;

use Yii;
use common\modules\cms\models\Category;
use common\modules\cms\models\CategorySearch;
use common\modules\cms\models\CmsContentType;
use common\modules\cms\models\CmsContentWidth;
use common\modules\cms\models\Frequency;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use niksko12\auditlogs\classes\ControllerAudit;
use yii\filters\AccessControl;
/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends ControllerAudit
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $category = ArrayHelper::map(Category::find()->select(['id','title'])->all(), 'id', 'title');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'category' => $category,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();
        $content_type = ArrayHelper::map(CmsContentType::find()->select(['id','type'])->all(), 'id', 'type');
        $content_width = ArrayHelper::map(CmsContentWidth::find()->all(), 'id', 'class_name');
        $frequency = ArrayHelper::map(Frequency::find()->all(), 'id', 'title');
        $applicable_to = ['0' => 'Field Officer Monitoring Form','2' => 'Public Survey Form'];
        $left_right = ['0'=>'Left', '1' => 'Right'];

        $qry = Category::find()->select(['sort'])->orderBy(['sort' => SORT_DESC])->One();
        
        $model->sort =  !empty($qry->sort) ? $qry->sort + 1 : null;

        if ($model->load(Yii::$app->request->post())) {
           
                $model->save();
           
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'content_type' => $content_type,
                'content_width' => $content_width,
                'frequency' => $frequency,
                'applicable_to' => $applicable_to,
                'left_right' => $left_right,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $content_type = ArrayHelper::map(CmsContentType::find()->select(['id','type'])->all(), 'id', 'type');
        $content_width = ArrayHelper::map(CmsContentWidth::find()->all(), 'id', 'class_name');
        $frequency = ArrayHelper::map(Frequency::find()->all(), 'id', 'title');

        $applicable_to = ['0' => 'Field Officer Monitoring Form','2' => 'Public Survey Form'];
        $left_right = ['0'=>'Left', '1' => 'Right'];



        if ($model->load(Yii::$app->request->post())) {
           
           $model->save();
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'content_type' => $content_type,
                'content_width' => $content_width,
                'frequency' =>  $frequency,
                'applicable_to' => $applicable_to,
                'left_right' => $left_right,
            ]);
        }
    }

    public function actionUpdateSort($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {

            $model->save();
            
            return $this->redirect(['index','CategorySearch[applicable_to]' => $model->applicable_to]);
        } else {
            return $this->render('update_sort', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
