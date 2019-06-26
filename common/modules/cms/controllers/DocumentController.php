<?php

namespace common\modules\cms\controllers;

use Yii;
use common\modules\cms\models\Category;
use common\modules\cms\models\DocumentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;
use common\models\MultipleModel;
use common\modules\cms\models\Value;
use yii\helpers\ArrayHelper;
use common\models\GadCategoryComment;
use common\models\GadRecord;

/**
 * DocumentController implements the CRUD actions for Category model.
 */
class DocumentController extends Controller
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

    public function actionCreatedDocument()
    {
        Yii::$app->session["activelink"] = "created_document";
        $searchModel = new DocumentSearch();
        $dataProvider = $searchModel->search_created_document(Yii::$app->request->queryParams);

        return $this->render('create_document',['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionDownloadWord($ruc,$category_id)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $queryValues = (new \yii\db\Query())
        ->select([
            'IND.title as indicator_title',
            'VAL.value',
            'CAT.title as category_title',
            'CAT.id as category_id',
            'REC.id as record_id',
            'IND.id as indicator_id',
            'REC.approved_by as record_approved_by'
        ])
        ->from('bpls_values VAL')
        ->leftJoin(['REC' => 'gad_record'], 'REC.id = VAL.yearly_record_id')
        ->leftJoin(['IND' => 'bpls_indicator'], 'IND.id = VAL.indicator_id')
        ->leftJoin(['CAT' => 'bpls_category'], 'CAT.id = IND.category_id')
        ->where(['REC.tuc' => $ruc, 'VAL.category_id' => $category_id])
        ->groupBy(['IND.id','VAL.id'])
        ->all();

        

        $arrCategory7 = [];
        $approvedBy = "";
        $record_id = null;
        $category_id = null;
        foreach ($queryValues as $key => $row) {
            if($row["category_id"] == 7)
            {
                $arrCategory7[] = $row["value"];
                $approvedBy = $row["record_approved_by"];
                $record_id = $row["record_id"];
                $category_id = $row["category_id"];
            }
        }

        $queryCatCom = GadCategoryComment::find()->where(['record_id' => $record_id, 'category_id' => $category_id])->all();


        return $this->render('word_document/letter_review',
            [
                'phpWord' => $phpWord, 
                'arrCategory7' => $arrCategory7,
                'approvedBy' => $approvedBy,
                'queryCatCom' =>$queryCatCom, 
            ]);
    }

    /**
     * Displays a single Record model.
     * @param integer $id
     * @return mixed
     */
    public function actionEditFormView($category_id, $ruc, $onstep, $tocreate)
    {
        $categories = Category::find()->where(['id' => $category_id])->all();
        $record = \common\models\GadRecord::find()->where(['tuc' => $ruc])->one();
        $record_id = $record->id;

        $data = array();
        $data2 = array();
        $value1 = null;

        // $contentType = null;

        foreach($categories as $category){
            foreach($category->allIndicators as $indicator)
            {
                // $contentType = $category->cmsContentType->id;
                $value1 = Value::find()->where(['category_id' => $category->id, 'indicator_id' => $indicator->id,'yearly_record_id' => $record_id])->one();
                $value = new Value();
                 if(!empty($value1)){
                     $value->attributes = $value1->attributes;
                   $withData = true;
                 }
                
                $value->category_title = $category->title;
                // $value->is_required = $indicator->is_required;
                $value->indicator_title = $indicator->title;
                $value->type_title = $indicator->typeTitle;
                $value->unit_title = $indicator->unitTitle;
                $value->category_title = $indicator->categoryTitle;
                $value->unit_id = $indicator->unit_id;
                // $value->yearly_record_id
                if($indicator->frequency)
                {
                    $value->frequency_details = $indicator->frequency->frequencyDetails;
                }
                $c = $indicator->choices;
                $value->choices = ArrayHelper::map($c,'value','value');
                $value->term_record_id = null;
                $value->yearly_record_id = $record_id;
                $value->category_id = $category->id;
                $value->indicator_id = $indicator->id;
                $value->ans = $indicator->answer;
                $value->subs = $indicator->subQuestions;
                $data[$value->indicator_id] = $value;
                foreach($indicator->subQuestions as $subquestion)
                {
                    $subvalue2 = Value::find()->where(['da_brgy_id' => $temp_da_brgy_id, 'category_id' => $category->id, 'indicator_id' => $indicator->id, 'sub_question_id' => $subquestion->id])->one();
                    $subvalue = new Value();
                    if(!empty($subvalue2)){
                        $subvalue->attributes = $subvalue2->attributes;
                    }
                    $subvalue->term_record_id = null;
                    $subvalue->category_id = $category->id;
                    $subvalue->indicator_id = $indicator->id;
                    $subvalue->sub_question_id = $subquestion->id;
                    $subvalue->sub_question = $subquestion->sub_question;
                    $subvalue->type = $subquestion->type;
                    $data2['ind'.$indicator->id.'sub'.$subvalue->sub_question_id] = $subvalue;
                }
            }
        }

        if(Model::loadMultiple($data, Yii::$app->request->post())) {
            Value::deleteAll(['yearly_record_id' => $record_id, 'category_id' => $category_id]);
                    foreach($data as $d)
                    {
                        //if($d->type_title != "title" && $d->type_title != "second-title" ){
                            // $d->da_brgy_id = $model->id;
                            // if($d->unit_title == "DROPDOWN"){
                            //     $d->value = $d->ans;
                            // }
                            if($d->unit_title == 'FILE ATTACHMENT'){
                                $d->imageFiles = \yii\web\UploadedFile::getInstances($d, "[$d->indicator_id]imageFiles");
                                // $d->value = $model->id.'_'.$d->category_id . '_' . $d->indicator_id;
                                $d->value = $d->category_id . '_' . $d->indicator_id;
                                $datas = [];
                                foreach ($d->imageFiles as $file) {
                                    // $fname = $model->id.'_'.$d->category_id . '_' . $d->indicator_id . '_' . $file->baseName . '.' . $file->extension;
                                    $fname = $d->category_id . '_' . $d->indicator_id . '_' . $file->baseName . '.' . $file->extension;
                                    $datas[] = [$d->value, $fname, $file->extension];
                                    // $file->saveAs('uploads/' . $model->id.'_'.$d->category_id . '_' . $d->indicator_id . '_' . $file->baseName . '.' . $file->extension);
                                    $file->saveAs('uploads/' .$d->category_id . '_' . $d->indicator_id . '_' . $file->baseName . '.' . $file->extension);
                                }
                                Yii::$app->db->createCommand()
                                    ->batchInsert('lgup_attachments',['value','filename','type'],$datas)
                                    ->execute();
                            }

                            $d->save(false);
                        //}
                    }
                return $this->redirect(['/cms/category-comment','ruc' => $ruc]);
            }

            if(Model::loadMultiple($data2, Yii::$app->request->post())) {

                    foreach($data2 as $d2)
                    {
                        if($d2->value != "" || !empty($d2->value)){
                            // $d2->da_brgy_id = $model->id;
                            if($d2->type == 7){
                                $d2->value = $d2->ans;
                            }
                            if($d2->type == 10){
                                $d2->imageFiles = \yii\web\UploadedFile::getInstances($d2, "[ind".$d2->indicator_id."sub".$d2->sub_question_id."]imageFiles");
                                // $d2->value = $model->id.'_'.$d2->category_id . '_' . $d2->indicator_id;
                                $d2->value = $d2->category_id . '_' . $d2->indicator_id;
                                $datas = [];
                                foreach ($d2->imageFiles as $file) {
                                    // $fname = $model->id.'_'.$d2->category_id . '_' . $d2->indicator_id . '_' . $file->baseName . '.' . $file->extension;
                                    $fname = $d2->category_id . '_' . $d2->indicator_id . '_' . $file->baseName . '.' . $file->extension;
                                    $datas[] = [$d2->value, $fname, $file->extension];
                                    // $file->saveAs('uploads/' . $model->id.'_'.$d2->category_id . '_' . $d2->indicator_id . '_' . $file->baseName . '.' . $file->extension);
                                    $file->saveAs('uploads/' .$d2->category_id . '_' . $d2->indicator_id . '_' . $file->baseName . '.' . $file->extension);
                                }
                                Yii::$app->db->createCommand()
                                    ->batchInsert('lgup_attachments',['value','filename','type'],$datas)
                                    ->execute();
                            }
                            $d2->save(false);
                        }
                    }
            }

        return $this->render('create_data', [
            // 'contentValue' => $contentValue,
            // 'contentExtension' => $contentExtension,
            // 'session' => $session,
            'data' => $data,
            'data2' => $data2,
            'ruc' => $ruc,
            // 'regm' => $regm,
            // 'prvm' => $prvm,
            // 'cmm' => $cmm,
            // 'model' => $model,
            // 'withData' => $withData,
        ]);
    } // adddata

    /**
     * Displays a single Record model.
     * @param integer $id
     * @return mixed
     */
    public function actionFormView($category_id, $ruc, $onstep, $tocreate)
    {
        $categories = Category::find()->where(['id' => $category_id])->all();
        $record = \common\models\GadRecord::find()->where(['tuc' => $ruc])->one();
        $record_id = $record->id;

        $data = array();
        $data2 = array();
        $value1 = null;
        // $contentType = null;

        foreach($categories as $category){
            foreach($category->allIndicators as $indicator)
            {
                // $contentType = $category->cmsContentType->id;
                $value1 = Value::find()->where(['category_id' => $category->id, 'indicator_id' => $indicator->id,'yearly_record_id' => $record_id])->one();
                $value = new Value();
                 if(!empty($value1)){
                     $value->attributes = $value1->attributes;
                   $withData = true;
                 }
                
                $value->category_title = $category->title;
                // $value->is_required = $indicator->is_required;
                $value->indicator_title = $indicator->title;
                $value->type_title = $indicator->typeTitle;
                $value->unit_title = $indicator->unitTitle;
                $value->category_title = $indicator->categoryTitle;
                $value->unit_id = $indicator->unit_id;
                // $value->yearly_record_id
                if($indicator->frequency)
                {
                    $value->frequency_details = $indicator->frequency->frequencyDetails;
                }
                $c = $indicator->choices;
                $value->choices = ArrayHelper::map($c,'value','value');
                $value->term_record_id = null;
                $value->yearly_record_id = $record_id;
                $value->category_id = $category->id;
                $value->indicator_id = $indicator->id;
                $value->ans = $indicator->answer;
                $value->subs = $indicator->subQuestions;
                $data[$value->indicator_id] = $value;
                foreach($indicator->subQuestions as $subquestion)
                {
                    $subvalue2 = Value::find()->where(['da_brgy_id' => $temp_da_brgy_id, 'category_id' => $category->id, 'indicator_id' => $indicator->id, 'sub_question_id' => $subquestion->id])->one();
                    $subvalue = new Value();
                    if(!empty($subvalue2)){
                        $subvalue->attributes = $subvalue2->attributes;
                    }
                    $subvalue->term_record_id = null;
                    $subvalue->category_id = $category->id;
                    $subvalue->indicator_id = $indicator->id;
                    $subvalue->sub_question_id = $subquestion->id;
                    $subvalue->sub_question = $subquestion->sub_question;
                    $subvalue->type = $subquestion->type;
                    $data2['ind'.$indicator->id.'sub'.$subvalue->sub_question_id] = $subvalue;
                }
            }
        }

        if(Model::loadMultiple($data, Yii::$app->request->post())) {
            if(!empty($value1)){
                Value::deleteAll(['yearly_record_id' => $record_id, 'category_id' => $category_id]);
            }
            
                    foreach($data as $d)
                    {
                        //if($d->type_title != "title" && $d->type_title != "second-title" ){
                            // $d->da_brgy_id = $model->id;
                            // if($d->unit_title == "DROPDOWN"){
                            //     $d->value = $d->ans;
                            // }
                            if($d->unit_title == 'FILE ATTACHMENT'){
                                $d->imageFiles = \yii\web\UploadedFile::getInstances($d, "[$d->indicator_id]imageFiles");
                                // $d->value = $model->id.'_'.$d->category_id . '_' . $d->indicator_id;
                                $d->value = $d->category_id . '_' . $d->indicator_id;
                                $datas = [];
                                foreach ($d->imageFiles as $file) {
                                    // $fname = $model->id.'_'.$d->category_id . '_' . $d->indicator_id . '_' . $file->baseName . '.' . $file->extension;
                                    $fname = $d->category_id . '_' . $d->indicator_id . '_' . $file->baseName . '.' . $file->extension;
                                    $datas[] = [$d->value, $fname, $file->extension];
                                    // $file->saveAs('uploads/' . $model->id.'_'.$d->category_id . '_' . $d->indicator_id . '_' . $file->baseName . '.' . $file->extension);
                                    $file->saveAs('uploads/' .$d->category_id . '_' . $d->indicator_id . '_' . $file->baseName . '.' . $file->extension);
                                }
                                Yii::$app->db->createCommand()
                                    ->batchInsert('lgup_attachments',['value','filename','type'],$datas)
                                    ->execute();
                            }

                            $d->save(false);
                            
                        //}
                    }
                    return $this->redirect(['/cms/category-comment','ruc' => $ruc]);
            }

            if(Model::loadMultiple($data2, Yii::$app->request->post())) {

                    foreach($data2 as $d2)
                    {
                        if($d2->value != "" || !empty($d2->value)){
                            // $d2->da_brgy_id = $model->id;
                            if($d2->type == 7){
                                $d2->value = $d2->ans;
                            }
                            if($d2->type == 10){
                                $d2->imageFiles = \yii\web\UploadedFile::getInstances($d2, "[ind".$d2->indicator_id."sub".$d2->sub_question_id."]imageFiles");
                                // $d2->value = $model->id.'_'.$d2->category_id . '_' . $d2->indicator_id;
                                $d2->value = $d2->category_id . '_' . $d2->indicator_id;
                                $datas = [];
                                foreach ($d2->imageFiles as $file) {
                                    // $fname = $model->id.'_'.$d2->category_id . '_' . $d2->indicator_id . '_' . $file->baseName . '.' . $file->extension;
                                    $fname = $d2->category_id . '_' . $d2->indicator_id . '_' . $file->baseName . '.' . $file->extension;
                                    $datas[] = [$d2->value, $fname, $file->extension];
                                    // $file->saveAs('uploads/' . $model->id.'_'.$d2->category_id . '_' . $d2->indicator_id . '_' . $file->baseName . '.' . $file->extension);
                                    $file->saveAs('uploads/' .$d2->category_id . '_' . $d2->indicator_id . '_' . $file->baseName . '.' . $file->extension);
                                }
                                Yii::$app->db->createCommand()
                                    ->batchInsert('lgup_attachments',['value','filename','type'],$datas)
                                    ->execute();
                            }
                            $d2->save(false);
                        }
                    }
            }

        return $this->render('create_data', [
            // 'contentValue' => $contentValue,
            // 'contentExtension' => $contentExtension,
            // 'session' => $session,
            'data' => $data,
            'data2' => $data2,
            'ruc' => $ruc,
            // 'regm' => $regm,
            // 'prvm' => $prvm,
            // 'cmm' => $cmm,
            // 'model' => $model,
            // 'withData' => $withData,
        ]);
    } // adddata

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex($ruc,$onstep,$tocreate)
    {
        $searchModel = new DocumentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ruc' => $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $ruc, $onstep,$tocreate)
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
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
     * Deletes an existing Category model.
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
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
