<?php

namespace common\modules\cms\controllers;

use Yii;
use common\modules\cms\models\Year;
use common\modules\cms\models\YearSearch;
use common\modules\cms\models\BarangayRecord;
use common\modules\cms\models\BarangayProfile;
use common\modules\cms\models\Term;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * YearController implements the CRUD actions for Year model.
 */
class YearController extends Controller
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
     * Lists all Year models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $searchModel = new YearSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Year model.
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
     * Creates a new Year model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Year();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Year model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Year model.
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
     * Finds the Year model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Year the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Year::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionYearList($province, $citymun, $barangay, $year)
    {
        $profile = BarangayProfile::find()->where(['province_c'=>$province, 'citymun_c'=>$citymun, 'barangay_c'=>$barangay])->One();
        $arr = [];
        if($profile){
            $qrys = BarangayRecord::find()->where(['brgy_profile_id'=>$profile->id, 'year' => $year])->all();
            if($qrys){
                $years = Year::find()->all();
                foreach($years as $year){
                    $arr[] = ['id'=>$year->title ,'text'=>$year->title ];
                }
            } 
        } 
        \Yii::$app->response->format = 'json';
        return $arr;
    }


    public function actionTermList($year)
    {
        $res = array();
        $terms = Term::find()->all();
        foreach($terms as $term){
            $cnt = 2;
            for($x = 0; $x <= 2; $x++){
                $y =  substr($term->title, 0, 4)+$x;
                if($y == $year){
                    $res = [$term->id , $term->title];
                    break;
                }
            }
        }
        \Yii::$app->response->format = 'json';
        return $res;
    }

    public function actionIdList($province, $citymun, $barangay, $year)
    {
        $res = "";
        $profile = BarangayProfile::find()->where(['province_c'=>$province, 'citymun_c'=>$citymun, 'barangay_c'=>$barangay])->One();
        if($profile){
            $qry = BarangayRecord::find()->where(['brgy_profile_id'=>$profile->id, 'year' => $year])->One();
            return !empty($qry) ? $qry->brgy_profile_id : "";
        } 
        \Yii::$app->response->format = 'json';
        return $res;
    }
}
