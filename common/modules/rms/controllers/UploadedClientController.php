<?php

namespace common\modules\rms\controllers;

use Yii;
use common\modules\rms\models\UploadedClient;
use common\modules\rms\models\BusinessType;
use common\modules\rms\models\UploadedClientSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UploadedClientController implements the CRUD actions for UploadedClient model.
 */
class UploadedClientController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $this->layout = 'publicview';
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
     * Displays a single UploadedClient model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        if(!Yii::$app->user->can('bpls_encode_registered_business')){
            \Yii::$app->getSession()->setFlash('warning', '<strong>Unable to encode registered business (excel)</strong>');
            return $this->redirect('@web/rms/dynamic-view/index');
        }

        $region_c = Yii::$app->user->identity->userinfo->REGION_C;
        $province_c = Yii::$app->user->identity->userinfo->PROVINCE_C;
        $citymun_c = Yii::$app->user->identity->userinfo->CITYMUN_C;

        return $this->render('view', [
            'model' => $this->findModel(['id' => $id, 'region_c' => $region_c, 'province_c' => $province_c, 'citymun_c' => $citymun_c]),
        ]);
    }

    /**
     * Creates a new UploadedClient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if(!Yii::$app->user->can('bpls_encode_registered_business')){
            \Yii::$app->getSession()->setFlash('warning', '<strong>Unable to encode registered business (excel)</strong>');
            return $this->redirect('@web/rms/dynamic-view/index');
        }

        $model = new UploadedClient();

        $type = ArrayHelper::map(BusinessType::find()->all(), 'id','description');

        if ($model->load(Yii::$app->request->post())) {
            $model->date_uploaded = date('Y-m-d');
            $model->region_c = !empty(Yii::$app->user->identity->userinfo->REGION_C) ? Yii::$app->user->identity->userinfo->REGION_C : null;
            $model->province_c = !empty(Yii::$app->user->identity->userinfo->PROVINCE_C) ? Yii::$app->user->identity->userinfo->PROVINCE_C : null;
            $model->citymun_c = !empty(Yii::$app->user->identity->userinfo->CITYMUN_C) ? Yii::$app->user->identity->userinfo->CITYMUN_C : null;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'type' => $type,
        ]);
    }

    /**
     * Updates an existing UploadedClient model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        if(!Yii::$app->user->can('bpls_encode_registered_business')){
            \Yii::$app->getSession()->setFlash('warning', '<strong>Unable to encode registered business (excel)</strong>');
            return $this->redirect('@web/rms/dynamic-view/index');
        }

        $region_c = Yii::$app->user->identity->userinfo->REGION_C;
        $province_c = Yii::$app->user->identity->userinfo->PROVINCE_C;
        $citymun_c = Yii::$app->user->identity->userinfo->CITYMUN_C;

        $model = $this->findModel(['id' => $id, 'region_c' => $region_c, 'province_c' => $province_c, 'citymun_c' => $citymun_c]);

        $type = ArrayHelper::map(BusinessType::find()->all(), 'id','description');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'type' => $type,
        ]);
    }

    /**
     * Deletes an existing UploadedClient model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        if(!Yii::$app->user->can('bpls_encode_registered_business')){
            \Yii::$app->getSession()->setFlash('warning', '<strong>Unable to encode registered business (excel)</strong>');
            return $this->redirect('@web/rms/dynamic-view/index');
        }

        $region_c = Yii::$app->user->identity->userinfo->REGION_C;
        $province_c = Yii::$app->user->identity->userinfo->PROVINCE_C;
        $citymun_c = Yii::$app->user->identity->userinfo->CITYMUN_C;

        $this->findModel(['id' => $id, 'region_c' => $region_c, 'province_c' => $province_c, 'citymun_c' => $citymun_c])->delete();        
        \Yii::$app->getSession()->setFlash('warning', 'Registered Business Deleted.');
        return $this->redirect(['/rms/dynamic-view/registered-business']);
    }

    /**
     * Finds the UploadedClient model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UploadedClient the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UploadedClient::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
