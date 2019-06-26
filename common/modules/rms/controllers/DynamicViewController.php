<?php

namespace common\modules\rms\controllers;

use Yii;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;
use niksko12\user\models\Barangay;
use common\modules\bops\models\OfficialsProfile;
use common\modules\bops\models\OfficialsProfileSearch;
use common\modules\bops\models\Term;
use common\modules\rms\models\Record;
use common\modules\rms\models\RecordSearch;
use common\modules\rms\models\Year;
use common\modules\rms\models\Category;
use common\modules\rms\models\Indicator;
use common\modules\rms\models\Value;
use common\modules\rms\models\DynamicViewAttachments;
use common\modules\rms\models\UploadForm;
use common\modules\rms\models\UploadedClient;
use common\modules\rms\models\UploadedClientSearch;
use common\modules\oms\models\BplsValidateReportHistory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\db\Query;
use yii\helpers\Url;
use yii\helpers\Json;
use niksko12\user\models\UserInfo;
use \PHPExcel;
use \PHPExcel_IOFactory;
use \PHPExcel_Worksheet_Drawing;
use \PHPExcel_Style_Border;
use \PHPExcel_Style_Fill;
use \PHPExcel_Style_Alignment;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use kartik\mpdf\Pdf;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;


/**
 * RecordController implements the CRUD actions for Record model.
 */
class DynamicViewController extends Controller
{
    /**
     * @inheritdoc
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

    public function actions()
    {
        return [
            // ...
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Lists all Record models.
     * @return mixed
     */
    public function QuestionStyle($value)
    {
        $question_style = "";
        if($value == "question-second-level-title")
        {
            $question_style = "font-weight:bold; font-size:14px;";
        }
        else if($value == "question-third-level-title")
        {
            $question_style = "font-weight:bold; font-size:12px;";
        }
        else if($value == "question-main-title")
        {
            $question_style = "font-weight:bold; font-size:16px;";
        }

        return $question_style;
    }

    /**
     * Lists all Record models.
     * @return mixed
     */

    // public function actionNcr($module,$controller,$action,$id)
    // {
    //     // print_r("gumana ka"); exit;
    //     Yii::$app->session['regionDefaultForm'] = "ncr";
    //     Yii::$app->session['defaultFormRegionName'] = "NATIONAL CAPITAL REGION";
    //     Yii::$app->session['defaulFormRegionCode'] = "13";
    //     // $this->redirect('index');
    // }

    public function actionIndex()
    {
        $model = new Record();

        if(!Yii::$app->user->can('bpls_answer_monitoring_form')){
            return $this->redirect('@web/rms/dynamic-view/create');
        }

        $user_info = Yii::$app->user->identity->userinfo;
        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
        $rolenames =  ArrayHelper::map($roles, 'name','name');

        $searchModel = new RecordSearch();

        $title = "";

        $regions = ArrayHelper::map(Region::find()->all(),'region_c','region_m');

        $provinces = [];
        $citymuns = [];
        $barangays = [];

        $years = ArrayHelper::map(Year::find()->all(),'title','title');

        $categories = Category::find()->orderBy(['id' => SORT_DESC])->all();
        $categories = ArrayHelper::map($categories,'id','title');


        $params = Yii::$app->request->queryParams;
        $array = Yii::$app->request->get();

        if(in_array('SuperAdministrator',$rolenames) || in_array('bpls_admin',$rolenames) || empty($user_info->REGION_C)){
            $regions = ArrayHelper::map(Region::find()->all(),'region_c','region_m');

              if(!empty($params['RecordSearch']['province_c'])){
                $searchModel->region_c = $params['RecordSearch']['region_c'];
                $searchModel->province_c = $params['RecordSearch']['province_c'];
                $provinces = Province::find()->where(['region_c' => $searchModel->region_c])->all();
                $provinces = ArrayHelper::map($provinces,'province_c','province_m');
              }

              if(!empty($params['RecordSearch']['citymun_c']))
              {
                $searchModel->region_c = $params['RecordSearch']['region_c'];
                $searchModel->province_c = $params['RecordSearch']['province_c'];
                $searchModel->citymun_c = $params['RecordSearch']['citymun_c'];
                $provinces = Province::find()->where(['region_c' => $searchModel->region_c])->all();
                $provinces = ArrayHelper::map($provinces,'province_c','province_m');
                $citymuns = Citymun::find()->where(['region_c' => $searchModel->region_c, 'province_c' =>  $searchModel->province_c])->all();
                $citymuns = ArrayHelper::map($citymuns,'citymun_c','citymun_m');

                if($params['RecordSearch']['citymun_c'] == "00"){
                    $barangays = Barangay::find()->select(['concat(citymun_c,barangay_c) as barangay_c', 'barangay_m'])->where(['region_c'=> 13,'province_c'=>39])->asArray()->all();
                } else {
                    $barangays = Barangay::find()->where(['province_c'=>$params['RecordSearch']['province_c'], 'citymun_c'=>$params['RecordSearch']['citymun_c']])->all();
                }
                    $barangays = ArrayHelper::map($barangays,'barangay_c','barangay_m');
              }

            // end of check query
        } else {
            if(!empty($user_info->CITYMUN_C) || in_array('City',$rolenames) || in_array('Municipality',$rolenames)){

                $searchModel->region_c = $user_info->REGION_C;
                $searchModel->province_c = $user_info->PROVINCE_C;
                $searchModel->citymun_c = $user_info->CITYMUN_C;
                $regions = Region::find()->where(['region_c' => $user_info->REGION_C])->all();
                $regions = ArrayHelper::map($regions,'region_c','region_m');
                $provinces = Province::find()->where(['region_c' => $user_info->REGION_C, 'province_c' => $user_info->PROVINCE_C])->all();
                $provinces = ArrayHelper::map($provinces,'province_c','province_m');
                $citymuns = Citymun::find()->where(['region_c' => $user_info->REGION_C, 'province_c' => $user_info->PROVINCE_C, 'citymun_c' => $user_info->CITYMUN_C])->all();
                $citymuns = ArrayHelper::map($citymuns,'citymun_c','citymun_m');

                if(!empty($user_info->CITYMUN_C)){
                     if($user_info->CITYMUN_C == "00"){
                        $barangays = Barangay::find()->select(['concat(citymun_c,barangay_c) as barangay_c', 'barangay_m'])->where(['region_c'=> 13,'province_c'=>39])->asArray()->all();
                    } else {
                        $barangays = Barangay::find()->where(['province_c'=>$user_info->PROVINCE_C, 'citymun_c'=>$user_info->CITYMUN_C])->all();
                    }
                }
                    $barangays = ArrayHelper::map($barangays,'barangay_c','barangay_m');
            }
            else if(!empty($user_info->PROVINCE_C) || in_array('Provincial',$rolenames)){
                $searchModel->region_c = $user_info->REGION_C;
                $searchModel->province_c = $user_info->PROVINCE_C;
                $regions = Region::find()->where(['region_c' => $user_info->REGION_C])->all();
                $regions = ArrayHelper::map($regions,'region_c','region_m');
                $provinces = Province::find()->where(['region_c' => $user_info->REGION_C, 'province_c' => $user_info->PROVINCE_C])->all();
                $provinces = ArrayHelper::map($provinces,'province_c','province_m');
                $citymuns = Citymun::find()->where(['region_c' => $user_info->REGION_C, 'province_c' => $user_info->PROVINCE_C])->all();
                $citymuns = ArrayHelper::map($citymuns,'citymun_c','citymun_m');
            }
            else if(!empty($user_info->REGION_C) || in_array('Regional',$rolenames)){
                $searchModel->region_c = $user_info->REGION_C;
                $regions = Region::find()->where(['region_c' => $user_info->REGION_C])->all();
                $regions = ArrayHelper::map($regions,'region_c','region_m');
                $provinces = Province::find()->where(['region_c' => $user_info->REGION_C])->all();
                $provinces = ArrayHelper::map($provinces,'province_c','province_m');

            }

            // check query

              if(!empty($params['RecordSearch']['province_c'])){
                $searchModel->region_c = $params['RecordSearch']['region_c'];
                $searchModel->province_c = $params['RecordSearch']['province_c'];
                $provinces = Province::find()->where(['region_c' => $searchModel->region_c])->all();
                $provinces = ArrayHelper::map($provinces,'province_c','province_m');
              }

              if(!empty($params['RecordSearch']['citymun_c']))
              {
                $searchModel->region_c = $params['RecordSearch']['region_c'];
                $searchModel->province_c = $params['RecordSearch']['province_c'];
                $searchModel->citymun_c = $params['RecordSearch']['citymun_c'];
                $provinces = Province::find()->where(['region_c' => $searchModel->region_c])->all();
                $provinces = ArrayHelper::map($provinces,'province_c','province_m');
                $citymuns = Citymun::find()->where(['region_c' => $searchModel->region_c, 'province_c' =>  $searchModel->province_c])->all();
                $citymuns = ArrayHelper::map($citymuns,'citymun_c','citymun_m');

                if($params['RecordSearch']['citymun_c'] == "00"){
                    $barangays = Barangay::find()->select(['concat(citymun_c,barangay_c) as barangay_c', 'barangay_m'])->where(['region_c'=> 13,'province_c'=>39])->asArray()->all();

                } else {
                    $barangays = Barangay::find()->where(['province_c'=>$params['RecordSearch']['province_c'], 'citymun_c'=>$params['RecordSearch']['citymun_c']])->all();

                }
                $barangays = ArrayHelper::map($barangays,'barangay_c','barangay_m');
              }
            // end of check query
        }

        if(!empty($user_info->CITYMUN_C) && !empty($user_info->PROVINCE_C) && !empty($user_info->REGION_C)){
            $completeUserInfo = true;
        }
        else{
            $completeUserInfo = false;
        }


        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // echo "<pre>";
        // print_r($dataProvider);
        // exit();

        if(empty($params)){
            $a = 0;
        } else {
            $check = Record::find()->where(['region_c' => $searchModel->region_c, 'province_c' => $searchModel->province_c, 'citymun_c' => $searchModel->citymun_c])->One();
            if($check) { $a = 1; } else { $a = 0; }
        }

        if($model->load(Yii::$app->request->post())){
            if(empty($model->dateRangeStart) || empty($model->dateRangeEnd) || $model->dateRangeStart == '' || $model->dateRangeEnd == ''){
                \Yii::$app->getSession()->setFlash('warning', '<strong>Please select from/to date. Failed to download survey</strong>');
                return $this->redirect(['index']);
            }
            else{
                $region_c = !empty(Yii::$app->user->identity->userinfo->region->region_c) ? Yii::$app->user->identity->userinfo->region->region_c : null;
                $province_c = !empty(Yii::$app->user->identity->userinfo->province->province_c) ? Yii::$app->user->identity->userinfo->province->province_c : null;
                $citymun_c = !empty(Yii::$app->user->identity->userinfo->citymun->citymun_c) ? Yii::$app->user->identity->userinfo->citymun->citymun_c : null;

                $record = Record::find()
                            ->where(['region_c' => $region_c, 'province_c' => $province_c, 'citymun_c' => $citymun_c, 'form_type' => $model->app_type])
                            ->andWhere(['between', 'date_added', $model->dateRangeStart, $model->dateRangeEnd])
                            ->orderBy(['form_type' => SORT_ASC])
                            ->all();

                if(empty($record)){
                    \Yii::$app->getSession()->setFlash('warning', '<strong>No Survey Found.</strong>');
                    return $this->redirect(['index']);
                }

                $indcators = Indicator::find()
                            ->where(['category_id' => $model->app_type])
                            ->orderBy(['id' => SORT_ASC])
                            ->all();    

                $spreadsheet = new Spreadsheet();
                $worksheet = $spreadsheet->getActiveSheet();
                $spreadsheet->getActiveSheet()->getStyle('A:Z')->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getStyle('A:Z')->getFont()->setSize(11);
                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle('B:Z')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                // $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);

                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ],
                ];  
                // echo "<pre>";
                // print_r(ArrayHelper::getColumn($indcators, 'title'));
                // print_r($indcators);
                // print_r($record);
                // exit();
                $worksheet->getCell('A1')->setValue('Questions:');
                $worksheet->getCell('A2')->setValue('Answers:');
                $spreadsheet->getActiveSheet()->fromArray(ArrayHelper::getColumn($indcators, 'title'),NULL,'B1');
                $surveyRow = 2;
                foreach ($record as $key => $rec) {           
                    $surveyAnswers = Value::find()->where(['da_brgy_id' => $rec->id])->indexBy(['indicator_id'])->all(); 
                    $spreadsheet->getActiveSheet()->fromArray(ArrayHelper::getColumn($surveyAnswers, 'value'),NULL,'B'.$surveyRow);   
                    $surveyRow++;     
                }
                // $worksheet->getCell('A1')->setValue('Sample');
                $apptype = $model->app_type == 1 ? ' (New Application)' : ' (Renewal)';
                $filename=date('F d, Y').$apptype.' - Survey from '.$model->dateRangeStart.' to '.$model->dateRangeEnd.'.xlsx';
                header('Content-Disposition: attachment;filename="'.$filename.'"');
                ob_end_clean();
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            }
        }

        return $this->render('index', [
            'completeUserInfo' => $completeUserInfo,
            'user_info' => $user_info,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'regions' => $regions,
            'provinces' => $provinces,
            'citymuns' => $citymuns,
            'barangays' => $barangays,
            'categories' => $categories,
            'a' => $a,
            'model' => $model,
        ]);
    }

    public function actionRegisteredBusiness()
    {
        $model = new UploadForm();
        if(!Yii::$app->user->can('bpls_add_registered_business')){
            \Yii::$app->getSession()->setFlash('warning', '<strong>Unable to add registered business</strong>');
            return $this->redirect(['index']);
        }
        $excelFilename = null;
        $worksheet = null;
        $excelData = [];
        $excelDataForUploading = [];
        // Uploaded Registered Businesses per LGU
        $region_c = Yii::$app->user->identity->userinfo->REGION_C;
        $province_c = Yii::$app->user->identity->userinfo->PROVINCE_C;
        $citymun_c = Yii::$app->user->identity->userinfo->CITYMUN_C;


        $searchModel = new UploadedClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $registeredBusinesses = new ActiveDataProvider([
        //     'query' => (new yii\db\Query)
        //                 ->select(['first_name','middle_name','last_name','application_no','application_date','business_name','business_tin','bpls_business_type.description'])
        //                 ->from('bpls_uploaded_client')
        //                 ->leftJoin(['bpls_business_type'], 'bpls_uploaded_client.business_type = bpls_business_type.id')
        //                 ->where(['region_c' => $region_c,'province_c' => $province_c,'citymun_c' => $citymun_c])
        //                 ->orderBy(['application_no' => SORT_ASC]),
        //     'pagination' => [
        //         'pageSize' => 15,
        //     ],
        //     'sort' => false,
        // ]);

        $businessPermit = ArrayHelper::getColumn($dataProvider->query->all(), 'application_no');

        if (Yii::$app->request->isPost) {
            if(!Yii::$app->user->can('bpls_upload_excel')){
                \Yii::$app->getSession()->setFlash('warning', '<strong>Unable to upload registered business (excel)</strong>');
                return $this->redirect(['index']);
            }
            $session = Yii::$app->session;
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(TRUE);
                $spreadsheet = $reader->load("uploads/" .Yii::$app->user->identity->id.'-'.date('mdY').'-'.$model->imageFile->baseName.'.'.$model->imageFile->extension);
                $worksheet = $spreadsheet->getActiveSheet();
                foreach ($worksheet->getRowIterator() as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(FALSE);
                    foreach ($cellIterator as $key => $cell) {
                        if($cell->getRow() >= 2){
                            if($cell->getColumn() != 'F'){
                              if($cell->getColumn() == 'D'){
                                $excelData[$cell->getRow()][] = \PhpOffice\PhpSpreadsheet\Style\NumberFormat::toFormattedString($cell->getValue(), 'YYYY-MM-DD');
                                $excelDataForUploading[$cell->getRow()][] = \PhpOffice\PhpSpreadsheet\Style\NumberFormat::toFormattedString($cell->getValue(), 'YYYY-MM-DD');
                              }
                              else if($cell->getColumn() == 'A' || $cell->getColumn() == 'B' || $cell->getColumn() == 'C' || $cell->getColumn() == 'D' || $cell->getColumn() == 'E'){
                                $excelData[$cell->getRow()][] = $cell->getValue();
                                $excelDataForUploading[$cell->getRow()][1] = Yii::$app->user->identity->id;
                                $excelDataForUploading[$cell->getRow()][2] = $region_c;
                                $excelDataForUploading[$cell->getRow()][3] = $province_c;
                                $excelDataForUploading[$cell->getRow()][4] = $citymun_c;
                                $excelDataForUploading[$cell->getRow()][5] = date('Y-m-d');
                                // $excelDataForUploading[$cell->getRow()][11] = is_string($cell->getValue());
                                $excelDataForUploading[$cell->getRow()][] = $cell->getValue();
                              }
                            }
                        }
                    }
                }
                $session['excelData'] = $excelDataForUploading;
                $userinfo = Yii::$app->user->identity->id;
                $fileName = Yii::$app->user->identity->id.'-'.date('mdY').'-'.$model->imageFile->baseName;
                $ext = $model->imageFile->extension;

                // print_r($excelData);
                // exit();

                $session['excelFile'] = $fileName.'.'.$ext;
                $excelFilename = $fileName.'.'.$ext;
                Yii::$app->db->createCommand()->insert('bpls_attachments',
                    [
                        'user_id' => $userinfo,
                        'filename' => $fileName,
                        'type' => $ext,
                    ])
                ->execute();
            }
        }

        // $registeredBusinesses = (new \yii\db\Query())
        //         ->select(['first_name','middle_name','last_name','application_no','application_date'])
        //         ->from('bpls_uploaded_client')
        //         ->where(['region_c' => $region_c,'province_c' => $province_c,'citymun_c' => $citymun_c])
        //         ->orderBy(['application_no' => SORT_ASC])
        //         ->all();

        return $this->render('registered-business',[
            'model' => $model,
            'businessPermit' => $businessPermit,
            'excelData' => $excelData,
            // 'registeredBusinesses' => $registeredBusinesses,
            'excelFilename' => $excelFilename,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSaveExcelData()
    {
        $session = Yii::$app->session;
        $arr = array_values($session['excelData']);
        foreach ($arr as $key => $value) {
            $model = new UploadedClient();
            $model->user_id = $value[1];
            $model->region_c = $value[2];
            $model->province_c = $value[3];
            $model->citymun_c = $value[4];
            $model->date_uploaded = $value[5];
            $model->business_name = $value[6];
            $model->application_no = $value[7];
            $model->business_tin = $value[8];
            $model->application_date = $value[9];
            $model->business_type = $value[10];
            
            if($model->save()){

            }
            else{
                \Yii::$app->getSession()->setFlash('danger', 'Failed to upload.');
                return $this->redirect('@web/rms/dynamic-view/registered-business');
            }
        }
        $session['excelData'] = null;
        unlink('uploads/'. $session['excelFile']);
        $session['excelFile'] = null;
        \Yii::$app->getSession()->setFlash('success', 'Excel data successfully uploaded.');
        return $this->redirect('@web/rms/dynamic-view/registered-business');
    }

    /**
     * Displays a single Record model.
     * @param integer $id
     * @return mixed
     */

    public function actionFormFile($id, $uid){
        $model = $this->findModel(['id' => $id, 'hash' => $uid]);

        if(!empty($model->form_file) || $model->form_file != ''){
            $extension = $model->form_file_extension;
            $file = $model->form_file;
        }
        else{
            $extension = null;
            $file = null;
        }


        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                Yii::$app->db->createCommand()->update('bpls_record', 
                    [
                        'form_file' => md5(Yii::$app->user->identity->id.date('mdY').$model->imageFile->baseName.$model->imageFile->extension).'.'.$model->imageFile->extension,
                        'form_file_extension' => $model->imageFile->extension,
                    ], 
                    [
                        'id' => $id, 
                        'hash' => $uid
                    ])->execute();

                \Yii::$app->getSession()->setFlash('success','<strong>Successfully Uploaded</strong>');
                return $this->redirect(['index']);
            }
            else{
                \Yii::$app->getSession()->setFlash('warning','Failed to save files.');
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('form-file', [
            'extension' => $extension,
            'file' => $file,
            'model' => $model,
        ]);
    }

    public function FileExists($id, $uid)
    {
        $model = DynamicViewController::findModel(['id' => $id, 'hash' => $uid]);
        if(!empty($model->form_file) || $model->form_file != '')
        {
            return "yes";
        }
        else
        {
            return "no";
        }
    }

    public function actionRemoveAttachment($id, $uid){
        $model = $this->findModel(['id' => $id, 'hash' => $uid]);
        $tempFile = $model->form_file;
        $model->form_file = null;
        $model->form_file_extension = null;
        if($model->save()){
            unlink('uploads/forms/'. $tempFile);
            \Yii::$app->getSession()->setFlash('warning','<strong>Attachment has been removed.</strong>');
            return $this->redirect(['index']);
        }
        else{
            \Yii::$app->getSession()->setFlash('warning','<strong>Failed to remove the attached file.</strong>');
            return $this->redirect(['index']);
        }
    }

    public function actionView($id, $cat, $uid)
    {
        $activeCategory = $cat;
        $session = Yii::$app->session;
        $model = $this->findModel(['id' => $id, 'hash' => $uid]);
        $searchModel = new RecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Yii::$app->session['actionViewId'] = $id;
        Yii::$app->session['actionViewCat'] = $cat;
        Yii::$app->session['actionViewUid'] = $uid;

       // Override CityMun Access Rule Name in RBAC based on User
        $user = !empty(Yii::$app->user->identity->userinfo) ? Yii::$app->user->identity->userinfo : 0;
        if(!empty(Yii::$app->user->identity->userinfo)){
            if(($user->REGION_C == '13' && $user->PROVINCE_C == '39' && $user->CITYMUN_C == '00') || ($model->region_c == '13' && $model->province_c == '39')){
                $model->citymun_c = '00'; // Just to make equal the citymun_c of user the param for citymun_c;
            }
        }


        $categories = Category::find()->where(['id' => $cat])->all();

        $data = array();
        $data2 = array();

        foreach($categories as $category){
            foreach($category->allIndicators as $indicator){
                $value = Value::find()->where(['da_brgy_id' => $id, 'category_id' => $category->id, 'indicator_id' => $indicator->id])->One();
                if($value){
                    $value->category_title = $category->title;
                    $value->indicator_title = $indicator->title;
                    $value->part_of_chart = $indicator->in_chart;
                    $value->type_title = $indicator->typeTitle;
                    $value->unit_title = $indicator->unitTitle;
                    $value->category_title = $indicator->categoryTitle;
                    $value->unit_id = $indicator->unit_id;
                    $c = $indicator->choices;
                    $value->choices = ArrayHelper::map($c,'value','value');
                    $value->term_record_id = $id;
                    $value->category_id = $category->id;
                    $value->indicator_id = $indicator->id;
                    $value->ans = $indicator->answer;
                    $value->subs = $indicator->subQuestions;
                    $data[$value->indicator_id] = $value;

                    foreach($indicator->subQuestions as $subquestion){
                        $subvalue = Value::find()->where(['da_brgy_id' => $id, 'category_id' => $category->id, 'indicator_id' => $indicator->id, 'sub_question_id' => $subquestion->id])->One();
                        if($subvalue){
                            $subvalue->term_record_id = $id;
                            $subvalue->category_id = $category->id;
                            $subvalue->indicator_id = $indicator->id;
                            $subvalue->sub_question_id = $subquestion->id;
                            $subvalue->sub_question = $subquestion->sub_question;
                            $subvalue->type = $subquestion->type;
                            $data2[$subvalue->sub_question_id] = $subvalue;
                        }
                    }
                }

            }
        }

        $carouselImages = [];
        $chartCategories = [];
        $chartData = [];
        $imageArray = [];
        $tHeaders = [];
        $tDatas = [];
        $tChildDatas = [];
        $mapArray = [];
        if($model->formType->lgup_content_type_id == 5 || $model->formType->lgup_content_type_id == 6 || $model->formType->lgup_content_type_id == 4){
            foreach ($data as $key => $d) {
                if($d->unit_title == 'FILE ATTACHMENT'){
                    $images = DynamicViewAttachments::find()->where(['value' => $d->value])->all();
                    $imageArray = ArrayHelper::getColumn($images, 'filename');
                }
            }
            if($model->formType->lgup_content_type_id == 5){
                foreach ($imageArray as $key => $img) {
                        $carouselImages[$key]['content'] = Html::a(Html::img(Url::base().'/uploads/'.$img.'.',['alt'=>'images','class'=>'img-responsive','style' => 'width: 100%; margin: auto;height:100%']));
                }
            }
        }
        else if($model->formType->lgup_content_type_id == 10 || $model->formType->lgup_content_type_id == 9 || $model->formType->lgup_content_type_id == 2){
            foreach ($data as $key => $chart) {
                    $tHeaders[] = $chart->value;
                    $tHeaders[] = $chart->indicator_title;
                    $chartCategories = ArrayHelper::getColumn($chart->subs, 'sub_question');

                    if($chart->part_of_chart == 1){
                        $chartData[$key]['name'] = $chart->indicator_title;
                    }

                    foreach ($data2 as $key2 => $chartSubValue) {
                        if($chartSubValue->indicator_id == $chart->indicator_id){
                            $tDatas[] = [$chartSubValue->sub_question,$chartSubValue->value];
                            $dataValue = intval($chartSubValue->value);
                            if($chart->part_of_chart == 1){
                                $chartData[$key]['data'][$key2] = $dataValue;
                            }
                        }
                    }
            }
            foreach ($tDatas as $index => $datas) {
                $tChildDatas[$datas[0]][] = $datas[1];
            }
        }
        else if($model->formType->lgup_content_type_id == 7){
            foreach ($data as $key => $mapData) {
                foreach ($data2 as $key2 => $mapSubValue) {
                    if($key == $mapSubValue->indicator_id){
                        $mapArray[$key][] = $mapSubValue->value;
                    }
                }
            }
            foreach ($mapArray as $key => $mapData) {
                $images = DynamicViewAttachments::find()->select('filename')->where(['value' => $mapData[0]])->one();
                $mapArray[$key][0] = $images->filename;
            }

        }
        $tHeaders = array_unique($tHeaders);


        if (Yii::$app->request->post()) {
            $model->bp_status_id = 2;
            if(!$model->save()){                
                \Yii::$app->getSession()->setFlash('danger', 'Failed to save as final.');
            }
        }

        Yii::$app->session["actionViewAccess"] = "on";
        return $this->render('view', [
            'carouselImages' => $carouselImages,
            'imageArray' => $imageArray,
            'model' => $model,
            'data' => $data,
            'data2' => $data2,
            'chartCategories' => $chartCategories,
            'chartData' => $chartData,
            'tChildDatas' => $tChildDatas,
            'tHeaders' => $tHeaders,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'mapArray' => $mapArray,
            'id' => $id,
            'session' => $session,
            'activeCategory' => $activeCategory
        ]);
    } 

    public function actionSaveAsFinal($id,$uid)
    {
        $model = $this->findModel(['id' => $id, 'hash' => $uid]);
        $model->bp_status_id = 2;
        if($model->save()){
            \Yii::$app->getSession()->setFlash('success','<strong>Form has been saved as final</strong>');
            return $this->redirect(['index']);
        }
        else{            
            \Yii::$app->getSession()->setFlash('danger','<strong>Failed to save as final</strong>');
            return $this->redirect(['index']);
        }
    }

    public function actionViewattachments($id,$title,$id2,$cat)
    {
        $model = DynamicViewAttachments::find()->where(['value' => $id])->all();
        return $this->render('viewattachments',
            [
                'model' => $model,
                'cat' => $cat,
                'title' => $title,
                'id2' => $id2,
                'id' => $id
            ]);
    }



    /**
     * Displays a single Record model.
     * @param integer $id
     * @return mixed
     */
    public function actionAddData()
    {
        $model = new Record();
        $session = Yii::$app->session;

        $data2 = array();
        $contentType = null;
        $contentValue = 0;
        $contentExtension = 'jpg';
        $categories = Category::find()->where(['id' => $session['createdData']['form_type']])->all();

        if(Yii::$app->user->can('bpls_answer_monitoring_form') || Yii::$app->user->isGuest)
        {
            if(Yii::$app->user->can('bpls_admin_monitoring_form')){ // selection of psgc
                $userRegion = $session['createdData']['region_c'];
                $userProvince = $session['createdData']['province_c'];
                $userCitymun = $session['createdData']['citymun_c'];
                $userFName = $session['createdData']['first_name'];
                $userLName = $session['createdData']['last_name'];
                $userMName = $session['createdData']['middle_name'];
                $userID = null;
                $userTin = $session['createdData']['tin'];
                $userBName = $session['createdData']['business_name'];
                $userAppno = $session['createdData']['application_no'];
                
                $checkForm = Record::find()->where([
                    'region_c' => $userRegion,
                    'province_c' => $userProvince, 
                    'citymun_c' => $userCitymun,
                    'form_type' => $session['createdData']['form_type'],
                    'quarter' => $session['createdData']['quarter'],
                    'year' => $session['createdData']['year']
                ])
                ->exists();

                if($checkForm){
                   \Yii::$app->getSession()->setFlash('danger','<strong>Duplicate Entry Found.</strong>');
                    return $this->redirect(['/rms/dynamic-view/create']);
                }
            }
            else if(Yii::$app->user->isGuest)
            {
                $userFName = $session['createdData']['first_name'];
                $userLName = $session['createdData']['last_name'];
                $userMName = $session['createdData']['middle_name'];
                $userID = null;
                $userTin = $session['createdData']['tin'];
                $userBName = $session['createdData']['business_name'];
                $userAppno = $session['createdData']['application_no'];

                if(empty(Yii::$app->session['regionDefaultForm']))
                {
                    $userRegion = $session['createdData']['region_c'];
                    $userProvince = $session['createdData']['province_c'];
                    $userCitymun = $session['createdData']['citymun_c'];
                    
                }
                else
                {
                    $qryCitymun = Citymun::find()->where(['region_c' => Yii::$app->session['defaulFormRegionCode'], 'citymun_m' => $session['createdData']['citymun_c']])->one();
                    $getCitymunC = !empty($qryCitymun->citymun_c) ? $qryCitymun->citymun_c : "";
                    $getProvinceC = !empty($qryCitymun->province_c) ? $qryCitymun->province_c : "";
                    $userRegion = Yii::$app->session["defaulFormRegionCode"];
                    $userProvince = $getProvinceC;
                    $userCitymun = $getCitymunC;

                }
            }
            else{ // login session

                
                $checkForm = Record::find()->where([
                    'region_c' => $session['createdData']['region_c'],
                    'province_c' => $session['createdData']['province_c'], 
                    'citymun_c' => $session['createdData']['citymun_c'],
                    'form_type' => $session['createdData']['form_type'],
                    'quarter' => $session['createdData']['quarter'],
                    'year' => $session['createdData']['year']
                ])
                ->exists();

                if($checkForm){
                   \Yii::$app->getSession()->setFlash('danger','<strong>Duplicate Entry Found.</strong>');
                    return $this->redirect(['/rms/dynamic-view/create']);
                }

                if(empty(Yii::$app->user->identity->userinfo->REGION_C) || empty(Yii::$app->user->identity->userinfo->PROVINCE_C) || empty(Yii::$app->user->identity->userinfo->CITYMUN_C))
                {
                   \Yii::$app->getSession()->setFlash('danger','<strong>Incomplete Details about Region, Province, & City/Municipality. Please contact the administrator for some clarification.</strong>');
                    return $this->redirect(['//']);
                }
                else
                {
                    $userRegion = !empty(Yii::$app->user->identity->userinfo->REGION_C) ? Yii::$app->user->identity->userinfo->REGION_C : "";
                    $userProvince = !empty(Yii::$app->user->identity->userinfo->PROVINCE_C) ? Yii::$app->user->identity->userinfo->PROVINCE_C : "";
                    $userCitymun = !empty(Yii::$app->user->identity->userinfo->CITYMUN_C) ? Yii::$app->user->identity->userinfo->CITYMUN_C : "";
                    $userFName = Yii::$app->user->identity->userinfo->FIRST_M;
                    $userLName = Yii::$app->user->identity->userinfo->LAST_M;
                    $userMName = Yii::$app->user->identity->userinfo->MIDDLE_M;
                    $userTin = null;
                    $userBName = null;
                    $userAppno = null;
                    $userID = Yii::$app->user->identity->id;
                }
            }
        }
        else
        {
            \Yii::$app->getSession()->setFlash('danger','<strong>You have no permission to encode. Please contact the administrator for some clarification.</strong>');
                    return $this->redirect(['//']);
        }

        $temp_da_brgy_id = null;
        $value1 = null;
        $value2Userid = null;
        $withData = false;

        $reg = Region::find()->where(['region_c' => $userRegion])->one();
        $prv = Province::find()->where(['region_c' => $userRegion, 'province_c' => $userProvince])->one();
        $cm = Citymun::find()->where(['region_c' => $userRegion, 'province_c' => $userProvince,'citymun_c' => $userCitymun])->one();

        if(!empty(Yii::$app->session['actionViewAccess']))
        {
            return $this->redirect(['view', 'id' => Yii::$app->session['actionViewId'], 'cat' => Yii::$app->session['actionViewCat'], 'uid' => Yii::$app->session['actionViewUid']]);
        }
        else
        {

            if(empty($reg) || empty($prv) || empty($cm))
            {
                return $this->redirect('index');
            }
            else
            {
                $regm = $reg->region_m;
                $prvm = $prv->province_m;
                $cmm = !empty($cm->citymun_m) ? $cm->citymun_m : null;
            }
        }
        

        foreach($categories as $category){
            foreach($category->allIndicators as $indicator){
                $contentType = $category->cmsContentType->id;
                if(empty($temp_da_brgy_id) && Yii::$app->user->can('bpls_answer_monitoring_form')){
                    $value2 = Value::find()
                        ->select('bpls_values.*,bpls_record.user_id')
                        ->leftJoin('bpls_record', '`bpls_record`.`id` = `bpls_values`.`da_brgy_id`')
                        ->where([
                            'bpls_values.category_id' => $category->id,
                            'bpls_values.indicator_id' => $indicator->id,
                            'bpls_record.region_c' => $userRegion,
                            'bpls_record.province_c' => $userProvince,
                            'bpls_record.citymun_c' => $userCitymun,
                            'bpls_record.bp_status_id' => 2])
                        // ->andWhere([])
                        ->orderBy(['id' => SORT_DESC])
                        ->limit(1)
                        ->one();

                    if(!empty($value2)){
                        $temp_da_brgy_id = $value2->da_brgy_id;
                        $value2Userid = $value2->userRecord->user_id;
                    }
                }
                if(Yii::$app->user->can('bpls_answer_monitoring_form') && $value2Userid == $userID){
                   $value1 = Value::find()->where(['da_brgy_id' => $temp_da_brgy_id, 'category_id' => $category->id, 'indicator_id' => $indicator->id])->one();
                }
                $value = new Value();
                if(!empty($value1)){
                    $value->attributes = $value1->attributes;
                    $withData = true;
                }
                $value->category_title = $category->title;
                $value->is_required = $indicator->is_required;
                $value->indicator_title = $indicator->title;
                $value->type_title = $indicator->typeTitle;
                $value->unit_title = $indicator->unitTitle;
                $value->category_title = $indicator->categoryTitle;
                $value->unit_id = $indicator->unit_id;
                if($indicator->frequency){
                $value->frequency_details = $indicator->frequency->frequencyDetails;}
                $c = $indicator->choices;
                $value->choices = ArrayHelper::map($c,'value','value');
                $value->term_record_id = null;
                $value->yearly_record_id = null;
                $value->category_id = $category->id;
                $value->indicator_id = $indicator->id;
                $value->ans = $indicator->answer;
                $value->subs = $indicator->subQuestions;
                $data[$value->indicator_id] = $value;
                    foreach($indicator->subQuestions as $subquestion){
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
        if($contentType == 4){
            $contentExtension = ["png", "jpeg", "jpg", "bmp"];
            $contentValue = 1;
        }
        else if($contentType == 5){
            $contentExtension = ["png", "jpeg", "jpg", "bmp"];
            $contentValue = 99;
        }
        else if($contentType == 6){
            $contentValue = 1;
            $contentExtension = ["pdf"];
        }
        else if($contentType == 7){
            $contentExtension = ["png", "jpeg", "jpg", "bmp"];
            $contentValue = 1;
        }
        else if($contentType == 1){
            $contentExtension = ["png", "jpeg", "jpg", "bmp"];
            $contentValue = 1;
        }

        if (Yii::$app->request->post()) {

            $miliseconds = round(microtime(true) * 1000);
            $hash_value =  md5(date('Y-m-d')."-".date("h-i-sa")."-".$miliseconds);

            $model = new Record();
            $model->hash = $hash_value;
            $model->region_c = $userRegion;
            $model->province_c = $userProvince;
            $model->citymun_c = $userCitymun;
            $model->first_name = $userFName;
            $model->middle_name = $userMName;
            $model->last_name =  $userLName;
            $model->application_no = $userAppno;
            $model->form_type = $session['createdData']['form_type'];
            $model->tin = $userTin;
            $model->business_name = $userBName;
            $model->application_date = $session['createdData']['application_date'];
            $model->date_added = date('Y-m-d');
            $model->user_id = !empty(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : $session['createdData']['user_id'];
            $model->bp_status_id = Yii::$app->user->can("bpls_admin_monitoring_form")  ? 1 : 2;
            $model->report_transaction_id = $hash_value;
            $huc_qry = Citymun::find()->where(['region_c' => $userRegion, 'province_c' => $userProvince, 'citymun_c' => $userCitymun])->One();
            $get_huc = !empty($huc_qry->lgu_type) ? $huc_qry->lgu_type : "";
            $get_reg = !empty($huc_qry->region_c) ? $huc_qry->region_c : "";
            $get_prov = !empty($huc_qry->province_c) ? $huc_qry->province_c : "";
            $get_city = !empty($huc_qry->citymun_m) ? $huc_qry->citymun_m : "";
            if(Yii::$app->user->can('bpls_answer_monitoring_form')){
                $model->quarter = $session['createdData']['quarter'];
                $model->year = $session['createdData']['year'];
                if(Yii::$app->user->can("bpls_admin_monitoring_form")){
                    $model->is_valid = 7;
                }
                else
                {
                    $model->is_valid = 1;
                }
            }
            if($model->save()){

            }
            else{
                \Yii::$app->getSession()->setFlash('danger', 'Failed to save encoded form/survey.');
                return $this->redirect(['/rms/dynamic-view/create']);
            }

            // Save to Validate Report History
            date_default_timezone_set("Asia/Manila");
            $modelVRH = new BplsValidateReportHistory();
            $modelVRH->user_id = !empty(Yii::$app->user->identity->userinfo->user_id) ? Yii::$app->user->identity->userinfo->user_id : NULL;
            $modelVRH->record_id = $model->id;
            $modelVRH->region_c = $userRegion;
            $modelVRH->province_c = $userProvince;
            $modelVRH->citymun_c = $userCitymun;
            $modelVRH->date_validated =  date('Y-m-d');
            $modelVRH->time_validated = date("h:i:sa");
            $modelVRH->report_transaction_id = $hash_value;
            if(Yii::$app->user->can('bpls_admin_monitoring_form'))
            {
                $modelVRH->role = "central_office";
                $modelVRH->message = "Encoded by Central Office";
                $modelVRH->is_valid = 7;
            }
            else
            {
                $modelVRH->role = "bplo";
                $modelVRH->message = "Encoded by BPLO";
                $modelVRH->is_valid = 1;
            }
            $modelVRH->save();
            // Save to Validate Report History
            
            if(Model::loadMultiple($data, Yii::$app->request->post())) {
                    // echo "<pre>";
                    // print_r($data);
                    // exit();
                    foreach($data as $d)
                    {
                        //if($d->type_title != "title" && $d->type_title != "second-title" ){
                            $d->da_brgy_id = $model->id;
                            // if($d->unit_title == "DROPDOWN"){
                            //     $d->value = $d->ans;
                            // }
                            if($d->unit_title == 'FILE ATTACHMENT'){
                                $d->imageFiles = \yii\web\UploadedFile::getInstances($d, "[$d->indicator_id]imageFiles");
                                $d->value = $model->id.'_'.$d->category_id . '_' . $d->indicator_id;
                                $datas = [];
                                foreach ($d->imageFiles as $file) {
                                    $fname = $model->id.'_'.$d->category_id . '_' . $d->indicator_id . '_' . $file->baseName . '.' . $file->extension;
                                    $datas[] = [$d->value, $fname, $file->extension];
                                    $file->saveAs('uploads/' . $model->id.'_'.$d->category_id . '_' . $d->indicator_id . '_' . $file->baseName . '.' . $file->extension);
                                }
                                Yii::$app->db->createCommand()
                                    ->batchInsert('lgup_attachments',['value','filename','type'],$datas)
                                    ->execute();
                            }
                            $d->save(false);
                        //}
                    }
            }

            if(Model::loadMultiple($data2, Yii::$app->request->post())) {
                    foreach($data2 as $d2)
                    {
                        if($d2->value != "" || !empty($d2->value)){
                            $d2->da_brgy_id = $model->id;
                            if($d2->type == 7){
                                $d2->value = $d2->ans;
                            }
                            if($d2->type == 10){
                                $d2->imageFiles = \yii\web\UploadedFile::getInstances($d2, "[ind".$d2->indicator_id."sub".$d2->sub_question_id."]imageFiles");
                                $d2->value = $model->id.'_'.$d2->category_id . '_' . $d2->indicator_id;
                                $datas = [];
                                foreach ($d2->imageFiles as $file) {
                                    $fname = $model->id.'_'.$d2->category_id . '_' . $d2->indicator_id . '_' . $file->baseName . '.' . $file->extension;
                                    $datas[] = [$d2->value, $fname, $file->extension];
                                    $file->saveAs('uploads/' . $model->id.'_'.$d2->category_id . '_' . $d2->indicator_id . '_' . $file->baseName . '.' . $file->extension);
                                }
                                Yii::$app->db->createCommand()
                                    ->batchInsert('lgup_attachments',['value','filename','type'],$datas)
                                    ->execute();
                            }
                            $d2->save(false);
                        }
                    }
            }
            $session['createdData'] = null;
            $session['canUpdate'] = true;


            return $this->redirect(['view', 'id' => $model->id, 'cat' => $model->form_type, 'uid' => $model->hash]);

        } else {
            if(Yii::$app->controller->action->id == 'update'){
                return array('data' => $data, 'data2' => $data);
            }
            else{
                return $this->render('create_data', [
                    'contentValue' => $contentValue,
                    'contentExtension' => $contentExtension,
                    'session' => $session,
                    'data' => $data,
                    'data2' => $data2,
                    'regm' => $regm,
                    'prvm' => $prvm,
                    'cmm' => $cmm,
                    'model' => $model,
                    'withData' => $withData,
                ]);
            }
        }
    } // adddata

    public function actionUpdatedIndicators($id, $cat)
    {
        $model = Record::find()->where(['id' => $id])->one();
        $data = array();
        $data2 = array();
        $contentType = null;
        $contentValue = 0;
        $contentExtension = 'jpg';
        $categories = Category::find()->where(['id' => $cat])->all();

        foreach($categories as $category){
            foreach($category->allIndicators as $indicator){
                $contentType = $category->cmsContentType->id;
                $value = new Value();
                $value->category_title = $category->title;
                $value->indicator_title = $indicator->title;
                $value->type_title = $indicator->typeTitle;
                $value->unit_title = $indicator->unitTitle;
                $value->category_title = $indicator->categoryTitle;
                $value->unit_id = $indicator->unit_id;
                if($indicator->frequency){
                $value->frequency_details = $indicator->frequency->frequencyDetails;}
                $c = $indicator->choices;
                $value->choices = ArrayHelper::map($c,'value','value');
                $value->term_record_id = null;
                $value->yearly_record_id = null;
                $value->category_id = $category->id;
                $value->indicator_id = $indicator->id;
                $value->ans = $indicator->answer;
                $value->subs = $indicator->subQuestions;
                $data[$value->indicator_id] = $value;
                    foreach($indicator->subQuestions as $subquestion){
                    $subvalue = new Value();
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

        if($contentType == 4){
            $contentExtension = ["png", "jpeg", "jpg", "bmp"];
            $contentValue = 1;
        }
        else if($contentType == 5){
            $contentExtension = ["png", "jpeg", "jpg", "bmp"];
            $contentValue = 99;
        }
        else if($contentType == 6){
            $contentValue = 1;
            $contentExtension = ["pdf"];
        }
        else if($contentType == 7){
            $contentExtension = ["png", "jpeg", "jpg", "bmp"];
            $contentValue = 1;
        }
        return array('data' => $data, 'data2' => $data);
    }

    public function actionDownloadTemplate()
    {
        if(Yii::$app->user->can('bpls_download_template')){
            $path = Yii::getAlias('@webroot').'/uploads/registered-business-template.xlsx';
            if (file_exists($path)) {
                return Yii::$app->response->sendFile($path);
            }
        }
        else{
            \Yii::$app->getSession()->setFlash('warning', '<strong>Unable to download the template of registered business (excel)</strong>');
            return $this->redirect(['index']);
        }
    }

    public function actionUpdate($id, $cat, $uid)
    {
        $model = $this->findModel(['id' => $id, 'hash' => $uid]);
        $modelRecord = Record::find()->where(['id' => $model->id])->one();

        $session = Yii::$app->session;
        if($model->is_valid == 8 || $model->is_valid == 1){}
        else if(!$session['canUpdate']){
            if($model->bp_status_id == 1 && $model->user_id == Yii::$app->user->identity->id){}
            else{ return $this->redirect(['/']); }            
        }

        $userRegion = $model->region_c;
        $userProvince = $model->province_c;
        $userCitymun = $model->citymun_c;

        $reg = Region::find()->where(['region_c' => $userRegion])->one();
        $prv = Province::find()->where(['region_c' => $userRegion, 'province_c' => $userProvince])->one();
        $cm = Citymun::find()->where(['region_c' => $userRegion, 'province_c' => $userProvince,'citymun_c' => $userCitymun])->one();

        $regm = $reg->region_m;
        $prvm = $prv->province_m;
        $cmm = !empty($cm->citymun_m) ? $cm->citymun_m : null;

        $data = array();
        $data2 = array();
        $contentType = null;
        $withData = false;
        $contentValue = 0;
        $contentExtension = 'jpg';
        $categories = Category::find()/*->where(['frequency_id' => [1,2]])*/->all();

        foreach($categories as $category){
            foreach($category->allIndicators as $indicator){
                $contentType = $category->cmsContentType->id;
                $value = Value::find()->where(['da_brgy_id' => $model->id, 'category_id' => $category->id, 'indicator_id' => $indicator->id])->one();
                if($value){
                    $value->category_title = $category->title;
                    $value->indicator_title = $indicator->title;
                    $value->type_title = $indicator->typeTitle;
                    $value->unit_title = $indicator->unitTitle;
                    $value->category_title = $indicator->categoryTitle;
                    $value->unit_id = $indicator->unit_id;
                    $c = $indicator->choices;
                    $value->choices = ArrayHelper::map($c,'value','value');
                    $value->da_brgy_id = $model->id;
                    $value->category_id = $category->id;
                    $value->indicator_id = $indicator->id;
                    $value->ans = $indicator->answer;
                    $value->subs = $indicator->subQuestions;
                    $data[$value->indicator_id] = $value;

                    foreach($indicator->subQuestions as $subquestion){
                        $subvalue = Value::find()->where(['da_brgy_id' => $model->id, 'category_id' => $category->id, 'indicator_id' => $indicator->id, 'sub_question_id' => $subquestion->id])->one();
                        if($subvalue){
                            $subvalue->da_brgy_id = $model->id;
                            $subvalue->category_id = $category->id;
                            $subvalue->indicator_id = $indicator->id;
                            $subvalue->sub_question_id = $subquestion->id;
                            $subvalue->sub_question = $subquestion->sub_question;
                            $subvalue->type = $subquestion->type;
                            $data2['ind'.$indicator->id.'sub'.$subvalue->sub_question_id] = $subvalue;
                        }
                    }
                }
            }
        }

        if(empty($data)){
            return $this->redirect(['add-data', 'id' => $model->id, 'cat' => $model->form_type]);
        }

        if($contentType == 4){
            $contentExtension = ["png", "jpeg", "jpg", "bmp"];
            $contentValue = 1;
        }
        else if($contentType == 5){
            $contentExtension = ["png", "jpeg", "jpg", "bmp"];
            $contentValue = 99;
        }
        else if($contentType == 5){
            $contentValue = 1;
            $contentExtension = ["pdf"];
        }
        else if($contentType == 7){
            $contentExtension = ["png", "jpeg", "jpg", "bmp"];
            $contentValue = 1;
        }

        $addDataArray = $this->actionUpdatedIndicators($id, $cat);
        $addDatas = $addDataArray['data'];

        foreach ($addDatas as $keyData => $addData) {
            if(empty($data[$keyData])){
                $data[] = $addData;
            }
        }

        if(Yii::$app->request->post()) {
            if(Yii::$app->user->can("bpls_admin_monitoring_form")){
                $modelRecord->is_valid = $model->is_valid == 8 ? 1:7;
            }
            else
            {
                $modelRecord->is_valid = 1;
            }
            $modelRecord->save();

            if(Model::loadMultiple($data, Yii::$app->request->post())) {
                   foreach($data as $d)
                    {
                        $d->da_brgy_id = $model->id;
                        $d->save(false);
                    }
            }
            if(Model::loadMultiple($data2, Yii::$app->request->post())) {
                    foreach($data2 as $d2)
                    {                       
                        if($d2->value != "" || !empty($d2->value)){
                            $d2->da_brgy_id = $model->id;
                            $d2->save(false);
                        } else {
                            $d2->delete();
                        }
                    }
            }

            // \Yii::$app->getSession()->setFlash('success', 'You have successfully updated the information.');
            return $this->redirect(['view', 'id' => $model->id, 'cat' => $model->form_type, 'uid' => $model->hash]);
        } else {

            // echo "<pre>";
            // print_r($data);
            // print_r($data2);

            return $this->render('create_data', [
                'contentValue' => $contentValue,
                'contentExtension' => $contentExtension,
                'model' => $model,
                'data' => $data,
                'data2' => $data2,
                'session' => $session,
                'regm' => $regm,
                'prvm' => $prvm,
                'cmm' => $cmm,
                'withData' => $withData,
            ]);
        }
    }

    public function actionCreate($id = 'all')
    {

        $showLandingPage = "yes";
        $model = new Record();
        $session = Yii::$app->session;
        Yii::$app->session["actionViewAccess"] = NULL;
        switch ($id) {
            case 'ncr':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "NATIONAL CAPITAL REGION";
                Yii::$app->session['defaulFormRegionCode'] = "13";
                $showLandingPage = "no";
            break;
            case 'ilocos':
            case 'region1':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "REGION I - ILOCOS REGION";
                Yii::$app->session['defaulFormRegionCode'] = "01";
                $showLandingPage = "no";
            break;
            case 'cagayan':
            case 'region2':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "REGION II - CAGAYAN VALLEY";
                Yii::$app->session['defaulFormRegionCode'] = "02";
                $showLandingPage = "no";
            break;
            case 'central-luzon':
            case 'region3':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "REGION III - CENTRAL LUZON";
                Yii::$app->session['defaulFormRegionCode'] = "03";
                $showLandingPage = "no";
            break;
            case 'calabarzon':
            case 'region4a':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "REGION IV-A - CALABARZON";
                Yii::$app->session['defaulFormRegionCode'] = "04";
                $showLandingPage = "no";
            break;
            case 'bicol':
            case 'region5':
                Yii::$app->session['regionDefaultForm'] = "bicol";
                Yii::$app->session['defaultFormRegionName'] = "REGION V - BICOL REGION";
                Yii::$app->session['defaulFormRegionCode'] = "05";
                $showLandingPage = "no";
            break;
            case 'western-visayas':
            case 'region6':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "REGION VI - WESTERN VISAYAS";
                Yii::$app->session['defaulFormRegionCode'] = "06";
                $showLandingPage = "no";
            break;
            case 'central-visayas':
            case 'region7':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "REGION VII - CENTRAL VISAYAS";
                Yii::$app->session['defaulFormRegionCode'] = "07";
                $showLandingPage = "no";
            break;
            case 'eastern-visayas':
            case 'region8':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "REGION VIII - EASTERN VISAYAS";
                Yii::$app->session['defaulFormRegionCode'] = "08";
                $showLandingPage = "no";
            break;
            case 'zamboanga':
            case 'region9':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "REGION IX - ZAMBOANGA PENINSULA";
                Yii::$app->session['defaulFormRegionCode'] = "09";
                $showLandingPage = "no";
            break;
            case 'northern-mindanao':
            case 'region10':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "REGION X - NORTHERN MINDANAO";
                Yii::$app->session['defaulFormRegionCode'] = "10";
                $showLandingPage = "no";
            break;
            case 'davao':
            case 'region11':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "REGION XI - DAVAO REGION";
                Yii::$app->session['defaulFormRegionCode'] = "11";
                $showLandingPage = "no";
            break;
            case 'region12':
            case 'soccssargen':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "REGION XII - SOCCSSARGEN";
                Yii::$app->session['defaulFormRegionCode'] = "12";
                $showLandingPage = "no";
            break;
            case 'car':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "CORDILLERA ADMINISTRATIVE REGION";
                Yii::$app->session['defaulFormRegionCode'] = "14";
                $showLandingPage = "no";
            break;
            case 'armm':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "AUTONOMOUS REGION IN MUSLIM MINDANAO";
                Yii::$app->session['defaulFormRegionCode'] = "15";
                $showLandingPage = "no";
            break;
            case 'caraga':
            case 'region13':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "REGION XIII - CARAGA";
                Yii::$app->session['defaulFormRegionCode'] = "16";
                $showLandingPage = "no";
            break;
            case 'mimaropa':
            case 'region4b':
                Yii::$app->session['regionDefaultForm'] = $id;
                Yii::$app->session['defaultFormRegionName'] = "REGION IV-B -MIMAROPA";
                Yii::$app->session['defaulFormRegionCode'] = "17";
                $showLandingPage = "no";
            break;
            case 'all':
                Yii::$app->session['regionDefaultForm'] = NULL;
                Yii::$app->session['defaultFormRegionName'] = NULL;
                Yii::$app->session['defaulFormRegionCode'] = NULL;
                $showLandingPage = "yes";
            break;

            default:
                Yii::$app->session['regionDefaultForm'] = NULL;
                Yii::$app->session['defaultFormRegionName'] = NULL;
                Yii::$app->session['defaulFormRegionCode'] = NULL;
                $showLandingPage = "yes";
            break;
        }

        if(!empty($session['createdData'])){


            $model->region_c = $session['createdData']['region_c'];
            $model->province_c = $session['createdData']['province_c'];
            $model->citymun_c = $session['createdData']['citymun_c'];
            $model->first_name = Yii::$app->user->isGuest ? $session['createdData']['first_name'] : Yii::$app->user->identity->userinfo->FIRST_M;
            $model->middle_name = Yii::$app->user->isGuest ? $session['createdData']['middle_name'] : Yii::$app->user->identity->userinfo->MIDDLE_M;
            $model->last_name = Yii::$app->user->isGuest ? $session['createdData']['last_name'] : Yii::$app->user->identity->userinfo->LAST_M;
            $model->application_no = $session['createdData']['application_no'];
            $model->application_date = $session['createdData']['application_date'];
            $model->form_type = $session['createdData']['form_type'];
            $model->tin = $session['createdData']['tin'];
            $model->business_name = $session['createdData']['business_name'];
            $model->quarter = $session['createdData']['quarter'];
            $model->year = $session['createdData']['year'];

        }
        else{
            $session['canUpdate'] = false;
        }

        $user_info = !empty(Yii::$app->user->identity->userinfo) ? Yii::$app->user->identity->userinfo : 0;
        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
        $rolenames =  ArrayHelper::map($roles, 'name','name');

        if(!Yii::$app->user->can('bpls_answer_monitoring_form')){
            $categories = Category::find()->where(['applicable_to' => [2]])->orderBy(['id' => SORT_ASC])->all();
        }
        else{
            $categories = Category::find()->where(['applicable_to' => [0]])->orderBy(['id' => SORT_ASC])->all();
        }
        $categories = ArrayHelper::map($categories,'id','title');

        $years = ArrayHelper::map(Year::find()->all(),'title','title');
        $regions = ArrayHelper::map(Region::find()->all(),'region_c','region_m');
        // echo "<pre>";
        // print_r($regions); exit;
        $provinces = [];
        $barangays = [];
        $citymuns = [];

        // Condition for Default Form of Regions - Start
        if(empty(Yii::$app->session['regionDefaultForm']))
        {
            $citymuns = [];
        }
        else
        {
            $citymuns = ArrayHelper::map(Citymun::find()->where(['region_c' => Yii::$app->session['defaulFormRegionCode']])->all(),'citymun_m','citymun_m');

        }
        // Condition for Default Form of Regions - End

        

        if($model->load(Yii::$app->request->post())) {
            // Replace the value from tblbarangay data of citymun_c and barangay_c to fields of CITYMUN_C and BARANGAY_C
            // Not appropriate in beforeSave because will affect the promotions of SBM

            // if(!empty($session['createdData'])){
            //     $deleteOldData = Record::find()->where(['id' => $session['createdData']['id']])->One();
            //     if(!empty($deleteOldData)){
            //         $deleteOldData->delete();
            //     }
            //     $model->id = $session['createdData']['id'];
            // }
            // if($model->region_c == '13' && $model->province_c == '39'){
            //     $model->citymun_c = $model->new_citymun_c;
            //     $model->barangay_c = $model->new_brgy_c;
            // }
            if(Yii::$app->user->can('bpls_answer_monitoring_form') || Yii::$app->user->isGuest)
            {
                if(Yii::$app->user->can('bpls_admin_monitoring_form'))
                {

                    if(!empty(Yii::$app->session['regionDefaultForm']))
                    {
                        $qryCitymun = Citymun::find()->where(['region_c' => Yii::$app->session['defaulFormRegionCode'], 'citymun_m' => $session['createdData']['citymun_c']])->one();
                        $getCitymunC = !empty($qryCitymun->citymun_c) ? $qryCitymun->citymun_c : "";
                        $getProvinceC = !empty($qryCitymun->province_c) ? $qryCitymun->province_c : "";
                        $userRegion = Yii::$app->session["defaulFormRegionCode"];
                        // print_r($userRegion.'/'.$getProvinceC.'/'.$getCitymunC);exit;
                        $model->region_c = $userRegion;
                        $model->province_c = $getProvinceC;
                        $model->citymun_c = $getCitymunC;
                        $model->first_name = empty($model->first_name) || $model->first_name == '' ? $model->user->FIRST_M : $model->first_name;
                        $model->last_name = empty($model->last_name) || $model->last_name == '' ? $model->user->LAST_M : $model->last_name;
                        // $model->application_date = date('Y-m-d');
                        $model->user_id = !empty(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 0;
                    }
                    else
                    {
                        $model->region_c = empty($model->region_c) || $model->region_c == '' ? $model->user->region->region_c : $model->region_c;
                        $model->province_c = empty($model->province_c) || $model->province_c == '' ? $model->user->province->province_c : $model->province_c;
                        $model->citymun_c = empty($model->citymun_c) || $model->citymun_c == '' ? (!empty($model->userCitymun->citymun_c) ? $model->userCitymun->citymun_c : null) : (!empty($model->citymun_c) ? $model->citymun_c : null);
                        $model->first_name = empty($model->first_name) || $model->first_name == '' ? $model->user->FIRST_M : $model->first_name;
                        $model->last_name = empty($model->last_name) || $model->last_name == '' ? $model->user->LAST_M : $model->last_name;
                        // $model->application_date = date('Y-m-d');
                        $model->user_id = !empty(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 0;
                    }
                }
                else if(Yii::$app->user->isGuest)
                {
                    if(empty(Yii::$app->session['regionDefaultForm']))
                    {
                        $model->region_c = empty($model->region_c) || $model->region_c == '' ? $model->user->region->region_c : $model->region_c;
                        $model->province_c = empty($model->province_c) || $model->province_c == '' ? $model->user->province->province_c : $model->province_c;
                        $model->citymun_c = empty($model->citymun_c) || $model->citymun_c == '' ? (!empty($model->userCitymun->citymun_c) ? $model->userCitymun->citymun_c : null) : (!empty($model->citymun_c) ? $model->citymun_c : null);
                        $model->first_name = empty($model->first_name) || $model->first_name == '' ? null : $model->first_name;
                        $model->last_name = empty($model->last_name) || $model->last_name == '' ? null : $model->last_name;
                        // $model->application_date = date('Y-m-d');
                        $model->user_id = !empty(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 0;
                    }
                    
                }
                else
                {
                    if(empty(Yii::$app->user->identity->userinfo->REGION_C) || empty(Yii::$app->user->identity->userinfo->PROVINCE_C) || empty(Yii::$app->user->identity->userinfo->CITYMUN_C))
                    {
                       \Yii::$app->getSession()->setFlash('danger','<strong>Incomplete Details about Region, Province, & City/Municipality. Please contact the administrator for some clarification.</strong>');
                        return $this->redirect(['//']);
                    }
                    else
                    {
                        $model->region_c = empty($model->region_c) || $model->region_c == '' ? Yii::$app->user->identity->userinfo->region->region_c : $model->region_c;
                        $model->province_c = empty($model->province_c) || $model->province_c == '' ? Yii::$app->user->identity->userinfo->province->province_c : $model->province_c;
                        $model->citymun_c = empty($model->citymun_c) || $model->citymun_c == '' ? (!empty(Yii::$app->user->identity->userinfo->citymun->citymun_c) ? Yii::$app->user->identity->userinfo->citymun->citymun_c : null) : (!empty($model->citymun_c) ? $model->citymun_c : null);
                        $model->first_name = empty($model->first_name) || $model->first_name == '' ? Yii::$app->user->identity->userinfo->FIRST_M : $model->first_name;
                        $model->last_name = empty($model->last_name) || $model->last_name == '' ? Yii::$app->user->identity->userinfo->LAST_M : $model->last_name;
                        // $model->application_date = date('Y-m-d');

                        $model->user_id = !empty(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 0;
                    }
                    
                }
                
            }
            else{                
                Yii::$app->getSession()->setFlash('danger','<strong>You have no permission to perform this action. Please contact the administrator for some clarification.</strong>');
                return $this->redirect(['//']);
            }
            // $checkForm = Record::find()
            //             ->where(['region_c' => $model->region_c,'province_c' => $model->province_c, 'citymun_c' => $model->citymun_c,'form_type' => $model->form_type,'bp_status_id' => 1])
            //             ->exists();
            // if($checkForm){
            //     $usercity = empty($model->userCitymun) ? $model->citymun->citymun_m : $model->userCitymun->citymun_m;
            //     \Yii::$app->getSession()->setFlash('info','The '.$model->formType->title.' form(draft) for '.$usercity.' is already created. Failed to create form.');
            //     return $this->redirect(['create']);
            // }

            // if($model->save()){

            // }
            // else{
            //     print_r($model->getErrors());
            //     exit();
            // }
            $oldData = [];
            $oldData =  [
                            'region_c' => $model->region_c,
                            'province_c' => $model->province_c,
                            'citymun_c' => $model->citymun_c,
                            'first_name' => $model->first_name,
                            'middle_name' => $model->middle_name,
                            'last_name' => $model->last_name,
                            'application_no' => $model->application_no,
                            'form_type' => $model->form_type,
                            'tin' => $model->tin,
                            'business_name' => $model->business_name,
                            'application_date' => $model->application_date,
                            'user_id' => $model->user_id,
                            'quarter' => $model->quarter,
                            'year' => $model->year
                        ];
            $session['createdData'] = $oldData;

            return $this->redirect(['add-data']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'regions' => $regions,
                'provinces' => $provinces,
                'citymuns' => $citymuns,
                'barangays' => $barangays,
                'categories' => $categories,
                'showLandingPage' => $showLandingPage,
            ]);
        }
    }

    public function actionDelete($id)
    {
        // echo realpath(dirname(__FILE__).'/../../');
        // echo Url::base();
        // exit();

        $model = Record::find()->where(['id' => $id])->One();

        $categories = Category::find()->where(['frequency_id' => [1,2]])->all();
        foreach($categories as $category){
            foreach($category->allIndicators as $indicator){
            $value = Value::find()->where(['term_record_id' => $model->id, 'category_id' => $category->id, 'indicator_id' => $indicator->id])->One();
            if($value){
                $value->delete();
            }
                foreach($indicator->subQuestions as $subquestion){
                    $subvalue = Value::find()->where(['term_record_id' => $model->id, 'category_id' => $category->id, 'indicator_id' => $indicator->id, 'sub_question_id' => $subquestion->id])->One();
                    print_r($subvalue);
                    if($subvalue){
                        $subvalue->delete();
                    }
                }
            }
        }
        $uploadedForm = !empty($model->form_file) || $model->form_file != '' ? $model->form_file : null;
        if(!empty($uploadedForm)){
            unlink('uploads/forms/'. $model->form_file);
        }
        
        // $valPerAttachment = Value::find()->where(['da_brgy_id' => $id])->all();
        // foreach ($valPerAttachment as $key => $val) {
        //     $attachments = DynamicViewAttachments::find()->where(['like', 'filename', $val->da_brgy_id.'_'.$val->category_id.'_'.$val->indicator_id])->all();
        //     if($attachments){
        //         foreach ($attachments as $key => $row) {
        //             unlink('uploads/'. $row->filename);
        //             $row->delete();
        //         }
        //     }
        // }
        $model->delete();
        // \Yii::$app->getSession()->setFlash('danger', 'Form Deleted');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Record model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Record the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Record::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionLocationList($q = null)
    {
        //$user = UserInfo::findOne(Yii::$app->user->identity->id);

        $citymuns = new Query;

        $citymuns->select(['citymun_m','province_m', 'region_m', 'abbreviation', 'citymun_c', 'tblcitymun.province_c', 'tblcitymun.region_c'])
            ->from('tblcitymun')
            ->leftJoin('tblprovince', 'tblprovince.province_c = tblcitymun.province_c')
            ->leftJoin('tblregion', 'tblregion.region_c = tblcitymun.region_c')
            ->where('citymun_m LIKE "%' . $q .'%"')
            ->orWhere('concat(region_m,", ",citymun_m,", ", province_m) LIKE "%' . $q .'%"')
            ->orderBy('citymun_m');
        $command = $citymuns->createCommand();
        $cms = $command->queryAll();

        $cmsOut = [];
        foreach ($cms as $d) {
            $cmsOut[] = ['value' => trim($d['citymun_m']).', '.$d['province_m'].', '.$d['region_m'], 'citymun' => $d['citymun_m'], 'region' => $d['region_m'], 'address' => trim($d['citymun_m']).', '.$d['province_m'], 'region' => $d['abbreviation'],
                'url' => Url::to(['/drugaffectation/drug-affectation-barangay/index']).'?RecordSearch%5Bregion_c%5D='.$d['region_c'].'&RecordSearch%5Bprovince_c%5D='.$d['province_c'].'&RecordSearch%5Bcitymun_c%5D='.$d['citymun_c']];
        }

        echo Json::encode($cmsOut);
    }

    public function actionExcelReport()
    {
        $params = Yii::$app->request->queryParams;

        $user = UserInfo::findOne(Yii::$app->user->identity->id);

        $conditions = [];

        $query = Record::find();

        if(!empty($params['data']['RecordSearch']['region_c'])) $conditions['region_c'] = $params['data']['RecordSearch']['region_c'];
        if(!empty($params['data']['RecordSearch']['province_c'])) $conditions['province_c'] = $params['data']['RecordSearch']['province_c'];
        if(!empty($params['data']['RecordSearch']['citymun_c'])) $conditions['citymun_c'] = $params['data']['RecordSearch']['citymun_c'];
        if(!empty($params['data']['RecordSearch']['barangay_c'])) $conditions['barangay_c'] = $params['data']['RecordSearch']['barangay_c'];
        if(!empty($params['data']['RecordSearch']['year'])) $conditions['year'] = $params['data']['RecordSearch']['year'];

        $lgu = $query->where($conditions)->One();

        if(!($lgu)){
            return $this->redirect(['index']);
        }

        // style for the data cell
        $styleArray = array(
            'font' => array(
                'bold' => false,
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
             'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );

        // style for indicators (column headers)
        $headerStyleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        // style for barangay names (row headers)
        $rowHeaderStyleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        // initialize and check if province and citymun is empty
        $province = !empty($params['data']['RecordSearch']['province_c']) ? $params['data']['RecordSearch']['province_c']: "";
        $citymun = !empty($params['data']['RecordSearch']['citymun_c']) ? $params['data']['RecordSearch']['citymun_c']: "";
        $bar = !empty($params['data']['RecordSearch']['barangay_c']) ? $params['data']['RecordSearch']['barangay_c']: "";
        $year = !empty($params['data']['RecordSearch']['year']) ? $params['data']['RecordSearch']['year']: "";

        // create array for headers
        $headers = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ","BA","BB","BC","BD","BE","BF","BG","BH","BI","BJ","BK","BL","BM","BN","BO","BP","BQ","BR","BS","BT","BU","BV","BW","BX","BY","BZ"];

        // query to get all indicators
        $categories = Category::find()->where(['frequency_id' => [1,2]])->all();
        $b = 0; foreach($categories as $category){ $q = count($category->allQuestions); $b = $b + $q; } $b = $b + 4;

        // initialize spreadsheet
        $spreadsheet = new Spreadsheet();
        $excel = $spreadsheet->getActiveSheet();
        $excel->setTitle($lgu->citymunName." DRUG AFFECTATION"); // set sheet name


        $excel->getStyle('A1:Z999')->getAlignment()->setWrapText(true); // wrap text
        $excel->getColumnDimension('A')->setWidth(24); // set the width of column A (barangay name)

        // barangay location for main headers

        $excel->setCellValue('A1', 'REGION');
        $excel->mergeCells('B1:'.$headers[$b].'1');
        $excel->setCellValue('B1', $lgu->regionName);
        $excel->setCellValue('A2', 'PROVINCE');
        $excel->mergeCells('B2:'.$headers[$b].'2');
        $excel->setCellValue('B2', $lgu->provinceName);
        $excel->setCellValue('A3', $lgu->citymun->lgu_type == "M" ? 'MUNICIPALITY' : 'CITY');
        $excel->mergeCells('B3:'.$headers[$b].'3');
        $excel->setCellValue('B3', $lgu->citymunName);
        $excel->mergeCells('A4:'.$headers[$b].'4');

        // merge A5 to A7 - for title of all BARANGAYS
        $excel->mergeCells('A5:A7');
        $excel->setCellValue('A5', 'BARANGAYS')->getStyle('A5:A7')->applyFromArray($headerStyleArray);


        // header for Punong Barangay details
        $excel->mergeCells('B5:E6');
        $excel->setCellValue('B5', 'Punong Barangay')->getStyle('B5:E6')->applyFromArray($headerStyleArray);

        $excel->getColumnDimension('B')->setWidth(23);
        $excel->setCellValue('B7', 'Name')->getStyle('B7')->applyFromArray($headerStyleArray);

        $excel->getColumnDimension('C')->setWidth(23);
        $excel->setCellValue('C7', 'Contact Number')->getStyle('C7')->applyFromArray($headerStyleArray);

        $excel->getColumnDimension('D')->setWidth(23);
        $excel->setCellValue('D7', 'Address')->getStyle('D7')->applyFromArray($headerStyleArray);

        $excel->getColumnDimension('E')->setWidth(23);
        $excel->setCellValue('E7', 'Term')->getStyle('E7')->applyFromArray($headerStyleArray);

        // initialize needed variables (to be used for generation of headers - indicators)
        $i = 5;
        $cnt = 5;
        $start = 5;
        $cnt1 = 5;
        $start1 = 5;

        // category
        foreach($categories as $category){

            $no = count($category->allQuestions)-1;
            $formerge = $start + $no;
            $excel->mergeCells($headers[$cnt].'5'.':'.$headers[$formerge].'5');
            $excel->setCellValue($headers[$cnt].'5', $category->title)->getStyle($headers[$cnt].'5'.':'.$headers[$formerge].'5')->applyFromArray($headerStyleArray);
            $cnt = $formerge + 1;
            $start = $cnt;

            // parent indicator (title)
            foreach($category->allParent as $indicator){

                $no1 = count($indicator->child)-1;
                $formerge1 = $start1 + $no1;

                $excel->mergeCells($headers[$cnt1].'6'.':'.$headers[$formerge1].'6');
                $excel->setCellValue($headers[$cnt1].'6', strip_tags($indicator->title))->getStyle($headers[$cnt1].'6'.':'.$headers[$formerge1].'6')->applyFromArray($headerStyleArray);

                $cnt1 = $formerge1 + 1;
                $start1 = $cnt1;

                // child indicators (questions)
                foreach($indicator->child as $child){

                    // check if the indicator has sub question
                    $sub = "";
                    if($child->subQuestions){
                        foreach($child->subQuestions as $sub){
                            $s = $sub->sub_question;
                        }

                        // concatenate the subquestion to indicator title
                        $excel->getColumnDimension($headers[$i])->setWidth(28);
                        $excel->setCellValue($headers[$i].'7', strip_tags($child->title)."\n"."(If the answer is YES, the ".strtolower($sub->sub_question)." are indicated.)")->getStyle($headers[$i].'7')->applyFromArray($headerStyleArray);
                    } else{

                        // if indicator has no sub question, display the indicator title
                        $excel->getColumnDimension($headers[$i])->setWidth(18);
                        $excel->setCellValue($headers[$i].'7', strip_tags($child->title))->getStyle($headers[$i].'7')->applyFromArray($headerStyleArray);
                    }

                    $i++;
                }
            }
        }

        // initialize where the displaying of barangays should start
        $row = 8;

        // generates barangay names as row headers
        $barangays = Barangay::find()->where(['province_c' => $province, 'citymun_c' => $citymun])->all();




        if($citymun == "00"){
            $barangays = Barangay::find()->select(['concat(citymun_c,barangay_c) as barangay_c', 'barangay_m'])->where(['region_c'=> 13,'province_c'=>39])->asArray()->all();
        }else{
            $barangays = Barangay::find()->where(['province_c' => $province, 'citymun_c' => $citymun])->asArray()->all();

        }

        /*echo "<pre>";
        print_r($barangays);
        exit;*/


        foreach($barangays as $barangay){
            $excel->setCellValue('A'.$row, $barangay['barangay_m'])->getStyle('A'.$row)->applyFromArray($rowHeaderStyleArray);


            $brgy_rec = Record::find()->where(['province_c' => $province, 'citymun_c' => $citymun, 'barangay_c' => $barangay['barangay_c'], 'year' => $year])->One();
            if($brgy_rec && $brgy_rec->officialProfile) {
                $excel->setCellValue('B'.$row, $brgy_rec->pbName)->getStyle('B'.$row)->applyFromArray($styleArray);
                $excel->setCellValue('C'.$row, $brgy_rec->mobileNo)->getStyle('C'.$row)->applyFromArray($styleArray);
                $excel->setCellValue('D'.$row, $brgy_rec->address)->getStyle('D'.$row)->applyFromArray($styleArray);
                $excel->setCellValue('E'.$row, $brgy_rec->term)->getStyle('E'.$row)->applyFromArray($styleArray);
            } else {
                $excel->setCellValue('B'.$row, "")->getStyle('B'.$row)->applyFromArray($styleArray);
                $excel->setCellValue('C'.$row, "")->getStyle('C'.$row)->applyFromArray($styleArray);
                $excel->setCellValue('D'.$row, "")->getStyle('D'.$row)->applyFromArray($styleArray);
                $excel->setCellValue('E'.$row, "")->getStyle('E'.$row)->applyFromArray($styleArray);
            }

            // displaying data of the cell
            $y = 5;
            foreach($categories as $category){
                foreach($category->allQuestions as $indicator){ // get all indicator which type is question

                    // retrieve data from db, bis_values left join da_barangay
                    $qry = Value::find()->where(['indicator_id' => $indicator->id])->leftJoin('da_barangay', 'da_barangay.id = bis_values.da_brgy_id')
                    ->andFilterWhere(['da_barangay.province_c' => $province, 'da_barangay.citymun_c' => $citymun, 'da_barangay.barangay_c' => $barangay['barangay_c'], 'da_barangay.year' => $year])->One();

                    if($qry){ // if query is not empty
                        if($indicator->subQuestions && $indicator->answer == $qry->value){

                            // if indicator has sub-question and the it was answered by the user, then display the value
                            foreach($indicator->subQuestions as $sub){

                            // retrieve value(for sub_question) from db, bis_values left join da_barangay
                            $subvalue = Value::find()->where(['indicator_id' => $indicator->id, 'sub_question_id' => $sub->id])->leftJoin('da_barangay', 'da_barangay.id = bis_values.da_brgy_id')->andFilterWhere(['da_barangay.province_c' => $province, 'da_barangay.citymun_c' => $citymun, 'da_barangay.barangay_c' => $barangay['barangay_c'], 'da_barangay.year' => $year])->One();
                                if($subvalue){ // if query is not empty

                                    // then display the value for the sub-question, then set bg color
                                    $excel->setCellValue($headers[$y].$row, $subvalue->value)->getStyle($headers[$y].$row)->applyFromArray($styleArray);
                                    $excel->getStyle($headers[$y].$row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e8fce8');
                                } else {

                                    // if query is empty, display empty string
                                    $excel->setCellValue($headers[$y].$row, "")->getStyle($headers[$y].$row)->applyFromArray($styleArray);
                                }
                            }
                        } else {

                            // display the value for indicator, if indicator has no sub-question or it's value is not equal to default answer
                            $excel->setCellValue($headers[$y].$row, $qry->value)->getStyle($headers[$y].$row)->applyFromArray($styleArray);
                        }
                    } else {
                        $excel->setCellValue($headers[$y].$row, "")->getStyle($headers[$y].$row)->applyFromArray($styleArray); // if there is no data retrieve
                    }

                    $y++; // increment for columns
                }
            }

            $row++; // increment for rows
        }

        $date = date('Y-m-d');
        $filename=$lgu->citymunName.'_drug_affectation_report_'.date('Y-m-d', strtotime($date)).'.xlsx';

        header('Content-Disposition: attachment;filename="'.$filename.'"');
        ob_end_clean();
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function actionYearList($province, $citymun, $barangay, $year){

        $qry = Record::find()->where(['province_c' => $province, 'citymun_c' => $citymun, 'barangay_c' => $barangay, 'year' => $year])->One();

            $res = $qry ? true : false ;

        $years = Year::find()->all();
        $arr = [];
        $arr[] = ['id'=>'','text'=>''];
        if($years){
            foreach($years as $year){
                $arr[] = ['id'=>$year->title ,'text'=>$year->title];
            }
        }

        \Yii::$app->response->format = 'json';

        return array($res, $arr);
    }


    public function actionPrint($id){

        $model = $this->findModel($id);
        $date = date('Y-m-d');
        $d = date('F j, Y',strtotime($date));

        // start of query (data of indicators)

        $categories = Category::find()->where(['frequency_id' => [1,2]])->all();

        $data = array();
        $data2 = array();
        foreach($categories as $category){
            foreach($category->allIndicators as $indicator){
                $value = Value::find()->where(['da_brgy_id' => $id, 'category_id' => $category->id, 'indicator_id' => $indicator->id])->One();
                if($value){
                    $value->category_title = $category->title;
                    $value->indicator_title = $indicator->title;
                    $value->type_title = $indicator->typeTitle;
                    $value->unit_title = $indicator->unitTitle;
                    $value->category_title = $indicator->categoryTitle;
                    $value->unit_id = $indicator->unit_id;
                    $c = $indicator->choices;
                    $value->choices = ArrayHelper::map($c,'value','value');
                    $value->term_record_id = $id;
                    $value->category_id = $category->id;
                    $value->indicator_id = $indicator->id;
                    $value->ans = $indicator->answer;
                    $value->subs = $indicator->subQuestions;
                    $data[$value->indicator_id] = $value;

                    foreach($indicator->subQuestions as $subquestion){
                        $subvalue = Value::find()->where(['da_brgy_id' => $id, 'category_id' => $category->id, 'indicator_id' => $indicator->id, 'sub_question_id' => $subquestion->id])->One();
                        if($subvalue){
                            $subvalue->term_record_id = $id;
                            $subvalue->category_id = $category->id;
                            $subvalue->indicator_id = $indicator->id;
                            $subvalue->sub_question_id = $subquestion->id;
                            $subvalue->sub_question = $subquestion->sub_question;
                            $subvalue->type = $subquestion->type;
                            $data2[$subvalue->sub_question_id] = $subvalue;
                        }
                    }
                }
            }
        }

        // end of query (data of indicators)

        $content = $this->renderPartial('print' , ['model' => $model, 'data' => $data, 'data2' => $data2]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'filename' => $model->barangayName,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'marginLeft' => 20,
            'marginRight' => 20,
            'cssInline' => '#mainTable, td, th { border:1px solid #000; border-collapse:collapse; padding:6px 6px 6px 8px;}',
            'options' => ['title' => 'Complaint'],
            'methods' => [
                'SetHeader'=>false,
                'SetFooter'=>['Generated: '.$d],
            ]
        ]);

        $pdf->render();
    }



    /**
     * Returns all Barangays on a certain City/Municipalities.
     * @param string           $province     province_c     Province Code
     * @return Json {id:$barangay->barangay_c, text:$barangay->barangay_m}
     */
    public function actionNewCitymun($province, $barangay, $region)
    {
        $params = ['region_c'=>$region, 'province_c'=>$province, 'barangay_c'=>$barangay];
        $barangay = Barangay::find()->where($params)->One();
        $arr = $barangay->citymun_c;
        return $arr;
    }

    /**
     * Returns all Barangays on a certain City/Municipalities.
     * @param string           $province     province_c     Province Code
     * @return Json {id:$barangay->barangay_c, text:$barangay->barangay_m}
     */
    public function actionNewBarangay($province, $barangay, $region)
    {
        $params = ['region_c'=>$region, 'province_c'=>$province, 'barangay_c'=>$barangay];
        $barangay = Barangay::find()->where($params)->One();
        $arr = $barangay->barangay_c;
        return $arr;
    }

}
