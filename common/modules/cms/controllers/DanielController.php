<?php

namespace common\modules\awardsmemo\controllers;

use Yii;
use common\modules\awardsmemo\models\Awards;
use common\modules\awardsmemo\models\AwardsCriteria;
use common\modules\awardsmemo\models\Awardee;
use common\modules\awardsmemo\models\AwardsSearch;
use common\modules\attendance\models\AttendanceType;
use common\models\HrisWorkExperience;
use common\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use niksko12\user\models\Service;
use niksko12\user\models\Division;
use niksko12\user\models\Section;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;
use yii\db\Expression;
use yii\helpers\Url;
use NumberToWords\NumberToWords;
use DocxMerge\DocxMerge;

/**
 * AwardsController implements the CRUD actions for Awards model.
 */
class AwardsController extends Controller
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
     * Lists all Awards models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AwardsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $type = ArrayHelper::map(AttendanceType::find()->where(['attms_type_parent_id' => 1])->all(), 'id','description');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type,
        ]);
    }

    /**
     * Displays a single Awards model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modelAwardsCriteria = AwardsCriteria::find()->select('attms_type_id')->where(['attms_awards_id' => $id])->one();
        if(!empty($modelAwardsCriteria)){
            switch ($modelAwardsCriteria->attms_type_id) {
                case 17:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.sname', 'dta.fname', 'dta.mname', 'dta.extname'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'hris_i_personal_info'] , 'aa.hris_i_personal_info_id = dta.id')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
                case 18:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.SERVICE_C', 'dta.SERVICE_M'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'tblservice'] , 'aa.service_c = dta.SERVICE_C')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
                case 19:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.DIVISION_C', 'dta.DIVISION_M'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'tbldivision'] , 'aa.division_c = dta.DIVISION_C')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
                case 20:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.SECTION_C', 'dta.SECTION_M'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'tblsection'] , 'aa.section_c = dta.SECTION_C')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
                case 21:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.region_c', 'dta.region_m'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'tblregion'] , 'aa.region_c = dta.region_c')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
                case 22:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.region_c', 'dta1.province_c', 'dta1.province_m'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'tblregion'] , 'aa.region_c = dta.region_c')
                                     ->leftJoin(['dta1' => 'tblprovince'] , 'aa.province_c = dta1.province_c')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
                case 23:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.region_c', 'dta1.province_c', 'dta2.citymun_c', 'dta2.citymun_m'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'tblregion'] , 'aa.region_c = dta.region_c')
                                     ->leftJoin(['dta1' => 'tblprovince'] , 'aa.region_c = dta1.region_c AND aa.province_c = dta1.province_c')
                                     ->leftJoin(['dta2' => 'tblcitymun'] , 'aa.region_c = dta2.region_c AND aa.province_c = dta2.province_c AND aa.citymun_c = dta2.citymun_c')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
            }
        }
        else{
            $modelAwardees = null;
        }

        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
            'modelAwardsCriteria' => $modelAwardsCriteria,
            'modelAwardees' => $modelAwardees,
        ]);
    }

    public function actionDownloadCertificate($id){
        $modelAwards = Awards::find($id)->joinWith('attendanceType')->one();

        if(empty($modelAwards)){
            \Yii::$app->getSession()->setFlash('warning', '<strong>No Award/s Found.</strong>');
            return $this->redirect(['index']);
        }
        $modelAwardsCriteria = AwardsCriteria::find()->select('attms_type_id')->where(['attms_awards_id' => $id])->one();
        if(!empty($modelAwardsCriteria)){
            switch ($modelAwardsCriteria->attms_type_id) {
                case 17:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.sname', 'dta.fname', 'dta.mname', 'dta.extname'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'hris_i_personal_info'] , 'aa.hris_i_personal_info_id = dta.id')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
                case 18:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.SERVICE_C', 'dta.SERVICE_M'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'tblservice'] , 'aa.service_c = dta.SERVICE_C')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
                case 19:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.DIVISION_C', 'dta.DIVISION_M'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'tbldivision'] , 'aa.division_c = dta.DIVISION_C')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
                case 20:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.SECTION_C', 'dta.SECTION_M'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'tblsection'] , 'aa.section_c = dta.SECTION_C')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
                case 21:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.region_c', 'dta.region_m'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'tblregion'] , 'aa.region_c = dta.region_c')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
                case 22:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.region_c', 'dta1.province_c', 'dta1.province_m'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'tblregion'] , 'aa.region_c = dta.region_c')
                                     ->leftJoin(['dta1' => 'tblprovince'] , 'aa.province_c = dta1.province_c')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
                case 23:
                    $modelAwardees = (new yii\db\Query)
                                     ->select(['dta.region_c', 'dta1.province_c', 'dta2.citymun_c', 'dta2.citymun_m'])
                                     ->from('attms_awardee aa')
                                     ->leftJoin(['dta' => 'tblregion'] , 'aa.region_c = dta.region_c')
                                     ->leftJoin(['dta1' => 'tblprovince'] , 'aa.region_c = dta1.region_c AND aa.province_c = dta1.province_c')
                                     ->leftJoin(['dta2' => 'tblcitymun'] , 'aa.region_c = dta2.region_c AND aa.province_c = dta2.province_c AND aa.citymun_c = dta2.citymun_c')
                                     ->where(['aa.attms_awards_id' => $id])
                                     ->all();
                    break;
            }
        }
        else{
            $modelAwardees = null;
        }

        if(empty($modelAwardees)){
            \Yii::$app->getSession()->setFlash('warning', '<strong>No Awardee Found.</strong>');
            return $this->redirect(['index']);
        }

        // Generation of awards

        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection(['headerHeight' => 7100]);
        $header = $section->createHeader();
        $header->addWatermark('certbg.jpg',[
            'height' => '840', 
            'width' => '595',
            'marginTop' => -355, 
            'marginLeft' => -72, 
            'posHorizontal' => 'absolute',
            'posVertical' => 'absolute',
        ]);

        $phpWord->addFontStyle('nameStyle', ['bold'=>true, 'italic'=>false, 'size'=> 26, 'name' => 'Cambria']);
        $phpWord->addFontStyle('titleStyle', ['bold'=>true, 'italic'=>false, 'size'=> 20, 'name' => 'Cambria']);
        $phpWord->addFontStyle('descStyle', ['bold'=>false, 'italic'=>true, 'size'=> 16, 'name' => 'Cambria']);
        $phpWord->addFontStyle('silgNameStyle', ['bold'=>true, 'italic'=>true, 'size'=> 20, 'name' => 'Cambria']);
        $phpWord->addFontStyle('silgPosStyle', ['bold'=>true, 'italic'=>true, 'size'=> 16, 'name' => 'Cambria']);

        $phpWord->addParagraphStyle('pnameStyle', ['align'=>'center', 'spaceAfter'=> 250]);
        $phpWord->addParagraphStyle('ptitleStyle', ['align'=>'center']);
        $phpWord->addParagraphStyle('psilgStyle', ['align'=>'center', 'spaceBefore'=> 1000, 'spaceAfter'=> 0]);
        $phpWord->addParagraphStyle('psilgNameStyle', ['align'=>'center', 'spaceAfter'=> 0]);

        $i = 1;
        foreach ($modelAwardees as $key => $value) {
            switch ($modelAwardsCriteria->attms_type_id) {
                case 17:
                    $words = explode(" ", $value['mname']);
                    $letters = "";
                    foreach ($words as $word) {
                        $letters .= substr($word, 0, 1);
                    }
                    $myTextElement = $section->addText(strtoupper($value['fname'].' '.$letters.'. '.$value['sname']), 'nameStyle', 'pnameStyle');
                    break;
                case 18:
                    $myTextElement = $section->addText($value['SERVICE_M'], 'nameStyle', 'pnameStyle');
                    break;
                case 19:
                    $myTextElement = $section->addText($value['DIVISION_M'], 'nameStyle', 'pnameStyle');
                    break;
                case 20:
                    $myTextElement = $section->addText($value['SECTION_M'], 'nameStyle', 'pnameStyle');
                    break;
                case 21:
                    $myTextElement = $section->addText($value['region_m'], 'nameStyle', 'pnameStyle');
                    break;
                case 22:
                    $myTextElement = $section->addText($value['province_m'], 'nameStyle', 'pnameStyle');
                    break;
                case 23:
                    $myTextElement = $section->addText($value['citymun_m'], 'nameStyle', 'pnameStyle');
                    break;  
            }
            $myTextElement = $section->addText($modelAwards->attendanceType->description, 'titleStyle', 'ptitleStyle');
            $myTextElement = $section->addText($modelAwards->description, 'descStyle', 'ptitleStyle');

            $myTextElement = $section->addText('Given this '.date('d', strtotime($modelAwards->date)).date("S", mktime(0, 0, 0, 0, date('d', strtotime($modelAwards->date)), 0)).' day of '.date('F', strtotime($modelAwards->date)).' in the year of our Lord, '.ucwords($numberTransformer->toWords(2000)).' and '.ucwords($numberTransformer->toWords(date('y', strtotime($modelAwards->date)))).' at '.$modelAwards->location.'', 'descStyle', 'ptitleStyle');

            $myTextElement = $section->addText('_________________________________________', 'descStyle', 'psilgStyle');
            $myTextElement = $section->addText($modelAwards->silg_name, 'silgNameStyle', 'psilgNameStyle');
            $myTextElement = $section->addText($modelAwards->silg_position, 'silgPosStyle', 'psilgNameStyle');

            if($i != count($modelAwardees)){
                $section->addPageBreak();
            }
            $i++; 
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('certificates/certificateGenerated.docx');

        if(Yii::$app->user->can('attms_personnel')){
            $path = Yii::getAlias('@webroot').'/certificates/certificateGenerated.docx';
            if (file_exists($path)) {
                return Yii::$app->response->sendFile($path);
            }
        }
        else{
            \Yii::$app->getSession()->setFlash('warning', '<strong>Unable to download certificate</strong>');
            return $this->redirect(['index']);
        }

    }

    public function actionAddAwardee($id)
    {
        $model = $this->findModel($id);
        $select2Data = ['service_c' => [],'division_c' => [],'section_c'=> [],'region_c'=>[],'province_c'=>[],'citymun_c'=>[], 'hris_i_personal_info_id' => []];
        $awardee = null;
        $findRecord = AwardsCriteria::find()->where(['attms_awards_id' => $id])->one();
        $modelAwardee = new Awardee;
        if(!empty($findRecord)){
            $modelAwardsCriteria = $findRecord;
            $modelAwardee->type = $modelAwardsCriteria->attms_type_id;
            $awardee = Awardee::find()->select(['id','service_c','division_c','citymun_c','region_c','province_c','citymun_c','hris_i_personal_info_id','attms_awards_id','CONCAT(service_c,"-",division_c) as data_division_c', 'CONCAT(division_c,"-",section_c) as data_section_c', 'CONCAT(region_c,"-",province_c) as data_province_c', 'CONCAT(region_c,"-",province_c,"-",citymun_c) as data_citymun_c'])->where(['attms_awards_id' => $id])->all();

            $dataService = ArrayHelper::getColumn($awardee, 'service_c');
            $dataDivision = ArrayHelper::getColumn($awardee, 'data_division_c');
            $dataSection = ArrayHelper::getColumn($awardee, 'data_section_c');
            $dataRegion = ArrayHelper::getColumn($awardee, 'region_c');
            $dataProvince = ArrayHelper::getColumn($awardee, 'data_province_c');
            $dataCitymun = ArrayHelper::getColumn($awardee, 'data_citymun_c');

            switch ($modelAwardsCriteria->attms_type_id) {
                case 17:
                    $emps = ArrayHelper::getColumn($awardee,'hris_i_personal_info_id');
                    $concurrent = HrisWorkExperience::find()
                        ->select(['service_c', 'division_c', 'section_c', 'region_c', 'province_c', 'citymun_c'])
                        ->where(['hris_i_personal_info_id'=>$emps])
                        ->andWhere(['isdilg'=>1])
                        ->orderBy(['inclusivedates_from' =>SORT_DESC])
                        ->groupBy(['hris_i_personal_info_id'])
                        ->all();

                        $serviceList = array_unique(array_filter(ArrayHelper::getColumn($concurrent,'service_c')));
                        $divisionList = array_unique(array_filter(ArrayHelper::getColumn($concurrent,'division_c')));
                        $sectionList = array_unique(array_filter(ArrayHelper::getColumn($concurrent,'section_c')));
                        $regionList = array_unique(array_filter(ArrayHelper::getColumn($concurrent,'region_c')));
                        $provinceList = array_unique(array_filter(ArrayHelper::getColumn($concurrent,'province_c')));
                        $citymunList = array_unique(array_filter(ArrayHelper::getColumn($concurrent,'citymun_c')));

                        $regionList = array_flip($regionList);
                        unset($regionList['c0']);
                        $regionList = array_flip($regionList);

                        $modelAwardee->hris_i_personal_info_id = $emps;
                        if(!empty($serviceList)){
                            $modelAwardee->service_c = $serviceList;
                            $select2Data['service_c'] = ArrayHelper::map(Service::find()->all(), 'SERVICE_C', 'SERVICE_ACRONYM');
                        }
                        if(!empty($divisionList) || !empty($serviceList)){
                            $modelAwardee->division_c = $divisionList;
                            $select2Data['division_c'] = ArrayHelper::map((new yii\db\Query)->select(['CONCAT(SERVICE_C,"-",DIVISION_C) as servdiv, SERVICE_C, DIVISION_M'])->from('tbldivision')->where(['SERVICE_C' => $serviceList])->distinct()->orderBy(['SERVICE_C' => SORT_ASC])->all(), 'servdiv', 'DIVISION_M');
                        }
                        if(!empty($sectionList) || !empty($divisionList)){
                            $modelAwardee->section_c = $sectionList;
                            $select2Data['section_c'] = ArrayHelper::map((new yii\db\Query)->select(['CONCAT(DIVISION_C,"-",SECTION_C) as divsect, DIVISION_C, SECTION_M'])->from('tblsection')->where(['DIVISION_C' => $divisionList])->distinct()->orderBy(['DIVISION_C' => SORT_ASC])->all(), 'divsect', 'SECTION_M');
                        }
                        if(!empty($regionList)){
                            $modelAwardee->region_c = $regionList;
                            $select2Data['region_c'] =ArrayHelper::map(Region::find()->all(), 'region_c', 'abbreviation');
                        }
                        if(!empty($provinceList) || !empty($regionList)){
                            $modelAwardee->province_c = $provinceList;
                            $select2Data['province_c'] =ArrayHelper::map((new yii\db\Query)->select(['CONCAT(region_c,"-",province_c) as regprov, region_c, province_m'])->from('tblprovince')->where(['region_c' => $regionList])->all(), 'regprov', 'province_m');
                        }
                        if(!empty($citymunList) || !empty($provinceList) || !empty($regionList)){
                            $modelAwardee->citymun_c = $citymunList;
                            $select2Data['citymun_c'] =ArrayHelper::map((new yii\db\Query)->select(['CONCAT(region_c,"-",province_c,"-",citymun_c) as regprovcitymun, region_c, province_c, citymun_m'])->from('tblcitymun')->where(['region_c' => $regionList, 'province_c' => $provinceList])->all(), 'regprovcitymun', 'citymun_m');
                        }
                        $session = Yii::$app->session;
                        $session->open();
                        $session->set('s_service', !empty($serviceList) ? implode(',', $serviceList) : null);
                        $session->set('s_division', !empty($select2Data['division_c']) ? implode(',', array_keys($select2Data['division_c'])) : null);
                        $session->set('s_section', !empty($select2Data['section_c']) ? implode(',', array_keys($select2Data['section_c'])) : null);
                        $session->set('s_region', !empty($regionList) ? implode(',', $regionList) : null);
                        $session->set('s_province', !empty($select2Data['province_c']) ? implode(',', array_keys($select2Data['province_c'])) : null);
                        $session->set('s_citymun', !empty($select2Data['citymun_c']) ? implode(',', array_keys($select2Data['citymun_c'])) : null);
                        $session->close();

                        $select2Data['hris_i_personal_info_id'] = ArrayHelper::map($this->actionFindEmployees(), 'id', 'text');

                    break;
                case 18:
                        $modelAwardee->service_c = $dataService;
                        $select2Data['service_c'] = ArrayHelper::map(Service::find()->all(), 'SERVICE_C', 'SERVICE_ACRONYM');
                    break;
                case 19:
                        $modelAwardee->service_c = $dataService;
                        $modelAwardee->division_c = $dataDivision;
                        $select2Data['service_c'] = ArrayHelper::map(Service::find()->all(), 'SERVICE_C', 'SERVICE_ACRONYM');
                        $select2Data['division_c'] = ArrayHelper::map((new yii\db\Query)->select(['CONCAT(SERVICE_C,"-",DIVISION_C) as servdiv, SERVICE_C, DIVISION_M'])->from('tbldivision')->where(['SERVICE_C' => $dataService])->distinct()->orderBy(['SERVICE_C' => SORT_ASC])->all(), 'servdiv', 'DIVISION_M');
                    break;
                case 20:
                        $select2Data['section_c'] = ArrayHelper::map((new yii\db\Query)->select(['CONCAT(DIVISION_C,"-",SECTION_C) as divsect, DIVISION_C, SECTION_M'])->from('tblsection')->where(['DIVISION_C' => array_unique(ArrayHelper::getColumn($awardee, 'division_c'))])->distinct()->orderBy(['DIVISION_C' => SORT_ASC])->all(), 'divsect', 'SECTION_M');
                        $select2Data['service_c'] = ArrayHelper::map(Service::find()->all(), 'SERVICE_C', 'SERVICE_ACRONYM');

                        $divService = (new yii\db\Query)->select(['CONCAT(SERVICE_C,"-",DIVISION_C) as servdiv', 'SERVICE_C','DIVISION_C'])->where(['DIVISION_C' => array_unique(ArrayHelper::getColumn($awardee, 'division_c'))])->from('tbldivision')->all();

                        $select2Data['division_c'] = ArrayHelper::map((new yii\db\Query)->select(['CONCAT(SERVICE_C,"-",DIVISION_C) as servdiv, SERVICE_C, DIVISION_M'])->from('tbldivision')->where(['SERVICE_C' => ArrayHelper::getColumn($divService, 'SERVICE_C')])->distinct()->orderBy(['SERVICE_C' => SORT_ASC])->all(), 'servdiv', 'DIVISION_M');

                        $modelAwardee->service_c = array_unique(ArrayHelper::getColumn($divService, 'SERVICE_C'));
                        $modelAwardee->division_c = array_unique(ArrayHelper::getColumn($divService, 'servdiv'));
                        $modelAwardee->section_c = $dataSection;
                    break;
                case 21:
                        $modelAwardee->region_c = $dataRegion;
                        $select2Data['region_c'] = ArrayHelper::map(Region::find()->all(), 'region_c', 'abbreviation');
                    break;
                case 22:
                        $modelAwardee->region_c = $dataRegion;
                        $modelAwardee->province_c = $dataProvince;
                        $select2Data['region_c'] = ArrayHelper::map(Region::find()->all(), 'region_c', 'abbreviation');
                        $select2Data['province_c'] =ArrayHelper::map((new yii\db\Query)->select(['CONCAT(region_c,"-",province_c) as regprov, region_c, province_m'])->from('tblprovince')->where(['region_c' => $dataRegion])->all(), 'regprov', 'province_m');
                    break;
                case 23:
                        $modelAwardee->region_c = $dataRegion;
                        $modelAwardee->province_c = $dataProvince;
                        $modelAwardee->citymun_c = $dataCitymun;
                        $select2Data['region_c'] = ArrayHelper::map(Region::find()->all(), 'region_c', 'abbreviation');
                        $select2Data['province_c'] =ArrayHelper::map((new yii\db\Query)->select(['CONCAT(region_c,"-",province_c) as regprov, region_c, province_m'])->from('tblprovince')->where(['region_c' => $dataRegion])->all(), 'regprov', 'province_m');
                        $select2Data['citymun_c'] =ArrayHelper::map((new yii\db\Query)->select(['CONCAT(region_c,"-",province_c,"-",citymun_c) as regprovcitymun, region_c, province_c, citymun_m'])->from('tblcitymun')->where(['region_c' => $dataRegion, 'province_c' => array_unique(ArrayHelper::getColumn($awardee, 'province_c'))])->all(), 'regprovcitymun', 'citymun_m');
                    break;
            }
        }
        else{            
            $modelAwardsCriteria = new AwardsCriteria;
        }

        $type = ArrayHelper::map(AttendanceType::find()->where(['attms_type_parent_id' => [4,5]])->all(), 'id','description');

        if ($modelAwardee->load(Yii::$app->request->post())) {
            $db = Yii::$app->db;
            switch ($modelAwardee->type) {
                case 17:
                    for ($i=0; $i < count($modelAwardee->hris_i_personal_info_id); $i++) { 
                        $awardData[] = [$id,$modelAwardee->hris_i_personal_info_id[$i]];
                    }
                    $sql = $db->queryBuilder->batchInsert('attms_awardee', ['attms_awards_id','hris_i_personal_info_id'],$awardData);
                    $db->createCommand(str_replace("INSERT INTO ","REPLACE INTO",$sql))->execute();
                    break;
                case 18:
                    for ($i=0; $i < count($modelAwardee->service_c); $i++) { 
                        $awardData[] = [$id,$modelAwardee->service_c[$i]];
                    }
                    $sql = $db->queryBuilder->batchInsert('attms_awardee', ['attms_awards_id','service_c'],$awardData);
                    $db->createCommand(str_replace("INSERT INTO ","REPLACE INTO",$sql))->execute();
                    break;
                case 19:
                    for ($i=0; $i < count($modelAwardee->division_c); $i++) { 
                        $myDivision = explode('-', $modelAwardee->division_c[$i]);
                        $awardData[] = [$id,$myDivision[0], $myDivision[1]];
                    }
                    $sql = $db->queryBuilder->batchInsert('attms_awardee', ['attms_awards_id','service_c','division_c'],$awardData);
                    $db->createCommand(str_replace("INSERT INTO ","REPLACE INTO",$sql))->execute();
                    break;
                case 20:
                    for ($i=0; $i < count($modelAwardee->section_c); $i++) { 
                        $mySection = explode('-', $modelAwardee->section_c[$i]);
                        $awardData[] = [$id,$mySection[0], $mySection[1]];
                    }
                    $sql = $db->queryBuilder->batchInsert('attms_awardee', ['attms_awards_id','division_c','section_c'],$awardData);
                    $db->createCommand(str_replace("INSERT INTO ","REPLACE INTO",$sql))->execute();
                    break;
                case 21:
                    for ($i=0; $i < count($modelAwardee->region_c); $i++) { 
                        $awardData[] = [$id,$modelAwardee->region_c[$i]];
                    }
                    $sql = $db->queryBuilder->batchInsert('attms_awardee', ['attms_awards_id','region_c'],$awardData);
                    $db->createCommand(str_replace("INSERT INTO ","REPLACE INTO",$sql))->execute();
                    break;
                case 22:
                    for ($i=0; $i < count($modelAwardee->province_c); $i++) { 
                        $myProvince = explode('-', $modelAwardee->province_c[$i]);
                        $awardData[] = [$id,$myProvince[0], $myProvince[1]];
                    }
                    $sql = $db->queryBuilder->batchInsert('attms_awardee', ['attms_awards_id','region_c','province_c'],$awardData);
                    $db->createCommand(str_replace("INSERT INTO ","REPLACE INTO",$sql))->execute();
                    break;
                case 23:
                    for ($i=0; $i < count($modelAwardee->citymun_c); $i++) { 
                        $myCitymun = explode('-', $modelAwardee->citymun_c[$i]);
                        $awardData[] = [$id,$myCitymun[0], $myCitymun[1], $myCitymun[2]];
                    }
                    $sql = $db->queryBuilder->batchInsert('attms_awardee', ['attms_awards_id','region_c','province_c','citymun_c'],$awardData);
                    $db->createCommand(str_replace("INSERT INTO ","REPLACE INTO",$sql))->execute();
                    break;
            }
            $modelAwardsCriteria->attms_awards_id = $id;
            $modelAwardsCriteria->attms_type_id = $modelAwardee->type;
            $modelAwardsCriteria->type = 2;
            if($modelAwardsCriteria->save()){
                if(!empty($findRecord)){
                    Awardee::deleteAll(['id' => ArrayHelper::getColumn($awardee, 'id')]);
                }
                \Yii::$app->getSession()->setFlash('success', 'Successfully added awardee/s for "'.$model->attendanceType->description.'". Date: '.date('F d, Y', strtotime($model->date)).'');
            }
            else{
                \Yii::$app->getSession()->setFlash('danger', 'Error in saving.');
            }            
            return $this->redirect(['index']);
        }


        return $this->render('add_awardee', [
            'model' => $model,
            'modelAwardee' => $modelAwardee,
            'type' => $type,
            'select2Data' => $select2Data,
        ]);
    }

    public function actionFindService()
    {
        $type = Yii::$app->request->get('type');
        $arr = [];
        if(!empty($type)){
            $qry = Service::find()->all();
            foreach ($qry as $qryData) {
                $arr[] = [
                            'id' => $qryData->SERVICE_C,
                            'text' => $qryData->SERVICE_ACRONYM,
                         ];
            }
        }
        \Yii::$app->response->format = 'json';
        return $arr;
    }

    public function actionFindDivision()
    {
        $service_c = Yii::$app->request->get('service_c');
        $arr = [];
        if(!empty($service_c)){
            $qry = Division::find()->where(new Expression('SERVICE_C IN ('.$service_c.')'))->distinct()->orderBy(['SERVICE_C' => SORT_ASC])->all();
            foreach ($qry as $qryData) {
                $arr[] = [
                            'id' => $qryData->SERVICE_C.'-'.$qryData->DIVISION_C,
                            'text' => $qryData->sERVICE->SERVICE_ACRONYM.': '.$qryData->DIVISION_M,
                         ];
            }
        }
        \Yii::$app->response->format = 'json';
        return $arr;
    }

    public function actionFindSection()
    {
        $division_c = Yii::$app->request->get('division_c');
        $arr = [];
        if(!empty($division_c)){
            $exCData = null;
            $exData = explode(',', Yii::$app->request->get('division_c'));
            for ($i=0; $i < count($exData); $i++) { 
                $cData = explode('-', $exData[$i]);
                $exCData = !empty($exCData) ? $exCData.','.$cData[1] : $cData[1];
            }
            $qry = Section::find()->where(new Expression('DIVISION_C IN ('.$exCData.')'))->distinct()->orderBy(['DIVISION_C' => SORT_ASC])->all();
            foreach ($qry as $qryData) {
                $arr[] = [
                            'id' => $qryData->DIVISION_C.'-'.$qryData->SECTION_C,
                            'text' => $qryData->SECTION_M,
                         ];
            }
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }

    public function actionFindRegion()
    {
        $type = Yii::$app->request->get('type');
        $arr = [];
        if(!empty($type)){
            $qry = Region::find()->all();
            foreach ($qry as $qryData) {
                $arr[] = [
                            'id' => $qryData->region_c,
                            'text' => $qryData->abbreviation,
                         ];
            }
        }
        \Yii::$app->response->format = 'json';
        return $arr;
    }

    public function actionFindProvince()
    {
        $region_c = Yii::$app->request->get('region_c');
        $arr = [];
        if(!empty($region_c)){
            $qry = Province::find()->where(new Expression('region_c IN ('.$region_c.')'))->distinct()->orderBy(['region_c' => SORT_ASC])->all();
            foreach ($qry as $qryData) {
                $arr[] = [
                            'id' => $qryData->region_c.'-'.$qryData->province_c,
                            'text' => $qryData->province_m,
                         ];
            }
        }
        \Yii::$app->response->format = 'json';
        return $arr;
    }

    public function actionFindCitymun()
    {
        $region_c = Yii::$app->request->get('region_c');
        $province_c = Yii::$app->request->get('province_c');
        $arr = [];
        if(!empty($region_c) && !empty($province_c)){   
            $exCData = null;
            $exData = explode(',', Yii::$app->request->get('province_c'));
            for ($i=0; $i < count($exData); $i++) { 
                $cData = explode('-', $exData[$i]);
                $exCData = !empty($exCData) ? $exCData.','.$cData[1] : $cData[1];
            }
            $qry = Citymun::find()->where(new Expression('region_c IN ('.$region_c.') AND province_c IN ('.$exCData.')'))->distinct()->orderBy(['region_c' => SORT_ASC])->all();
            foreach ($qry as $qryData) {
                $arr[] = [
                            'id' => $qryData->region_c.'-'.$qryData->province_c.'-'.$qryData->citymun_c,
                            'text' => $qryData->citymun_m,
                         ];
            }
        }
        \Yii::$app->response->format = 'json';
        return $arr;

    }

    public function actionFindEmployees()
    {
        if(!empty(Yii::$app->request->get('id'))){
            $session = Yii::$app->session;
            $session->open();
            $r_service = $session->get('s_service');
            $r_division = $session->get('s_division');
            $r_section = $session->get('s_section');
            $r_region = $session->get('s_region');
            $r_province = $session->get('s_province');
            $r_citymun = $session->get('s_citymun');
        }
        else{
            $r_service = Yii::$app->request->get('service_c');
            $r_division = Yii::$app->request->get('division_c');
            $r_section = Yii::$app->request->get('section_c');
            $r_region = Yii::$app->request->get('region_c');
            $r_province = Yii::$app->request->get('province_c');
            $r_citymun = Yii::$app->request->get('citymun_c');
        }

        $service_c = empty($r_service) || $r_service == "" ?  null : 'dn.SERVICE_C IN ('.$r_service.')';
        $region_c = empty($r_region) || $r_region == "" ? null : 'rn.region_c IN ('.$r_region.')';

        if(empty($r_division) || $r_division == ""){
            $division_c = null;   
        }
        else{
            $exCData = null;
            $exData = explode(',', $r_division);
            for ($i=0; $i < count($exData); $i++) { 
                $cData = explode('-', $exData[$i]);
                $exCData = !empty($exCData) ? $exCData.','.$cData[1] : $cData[1];
            }
            $division_c = ' td.DIVISION_C IN ('.$exCData.')';
        }

        if(empty($r_section) || $r_section == ""){  
            $section_c = null;          
        }
        else{
            $exCData = null;
            $exData = explode(',', $r_section);
            for ($i=0; $i < count($exData); $i++) { 
                $cData = explode('-', $exData[$i]);
                $exCData = !empty($exCData) ? $exCData.','.$cData[1] : $cData[1];
            }
            $section_c = ' ts.SECTION_C IN ('.$exCData.')';
        }
        if(empty($r_province) || $r_province == ""){  
            $province_c = null;          
        }
        else{
            $exCData = null;
            $exData = explode(',', $r_province);
            for ($i=0; $i < count($exData); $i++) { 
                $cData = explode('-', $exData[$i]);
                $exCData = !empty($exCData) ? $exCData.','.$cData[1] : $cData[1];
            }
            $province_c = ' tp.province_c IN ('.$exCData.')';
        }

        if(empty($r_citymun) || $r_citymun == ""){  
            $citymun_c = null;          
        }
        else{
            $exCData = null;
            $exData = explode(',', $r_citymun);
            for ($i=0; $i < count($exData); $i++) { 
                $cData = explode('-', $exData[$i]);
                $exCData = !empty($exCData) ? $exCData.','.$cData[2] : $cData[2];
            }
            $citymun_c = ' tcm.citymun_c IN ('.$exCData.')';
        }

        $coQuery =  ''.(!empty($service_c) ? $service_c : '');
                    // .''.(!empty($division_c) && !empty($service_c) ? ' AND'.$division_c : $division_c).
                    // ''.(!empty($section_c) && (!empty($division_c) || !empty($service_c)) ? ' AND'.$section_c : $section_c);

        $roQuery =  ''.(!empty($region_c) ? $region_c : '');
                    // .''.(!empty($province_c) && !empty($region_c) ? ' AND'.$province_c : $province_c).
                    // ''.(!empty($citymun_c) && (!empty($province_c) || !empty($region_c)) ? ' AND'.$citymun_c : $citymun_c);

        if(!empty($service_c)){
             $coemployeeList = (new \yii\db\Query())
                ->select(['ui.id as hris_id, "CENTRAL" AS dname, UPPER(CONCAT(dn.SERVICE_ACRONYM, ": ", ui.sname,", ",ui.fname)) as fullNames, ui.id as "userid"'])
                ->from('hris_user as huser')
                ->leftJoin(['ui' => 'hris_i_personal_info'] , 'huser.hris_i_personal_info_id = ui.id')
                ->leftJoin(['tsuh' => 'hris_v_work_expe'] , 'ui.id = tsuh.hris_i_personal_info_id')
                ->leftJoin(['dn' => 'tblservice'] , 'tsuh.service_c = dn.SERVICE_C')
                ->leftJoin(['td' => 'tbldivision'] , 'tsuh.division_c = td.DIVISION_C')
                ->leftJoin(['ts' => 'tblsection'] , 'tsuh.section_c = ts.SECTION_C')
                ->leftJoin(['hgii' => 'hris_i_gov_issued_id'] , 'ui.id = hgii.hris_i_personal_info_id')
                ->where(['tsuh.office_c' => 5])
                ->andWhere(['tsuh.isdilg' => 1, 'tsuh.ispresent' => 1])
                ->andWhere(New Expression('hgii.agency IS NOT NULL'))
                ->andWhere(New Expression('hgii.agency != ""'))
                ->andWhere(New Expression('hgii.agency != "N/A"'.(empty($coQuery) || $coQuery == '' ? '' : ') AND ('.$coQuery).''))
                ->groupBy(['huser.hris_i_personal_info_id'])
                ->orderBy(['dn.SERVICE_C' => SORT_ASC, 'tsuh.inclusivedates_from' =>SORT_DESC])->distinct()
                ->all();
        }
        else{
            $coemployeeList = null;
        }

        if(!empty($region_c)){
            $roemployeeList = (new \yii\db\Query())
                ->select(['ui.id as userid, UPPER(CONCAT(rn.region_m, ": ", ui.sname,", ",ui.fname)) as fullNames, "REGIONAL" as dname, hgii.agency as "id_number"'])
                ->from('hris_user as huser')
                ->leftJoin(['ui' => 'hris_i_personal_info'] , 'huser.hris_i_personal_info_id = ui.id')
                ->leftJoin(['tsuh' => 'hris_v_work_expe'] , 'ui.id = tsuh.hris_i_personal_info_id')
                ->leftJoin(['rn' => 'tblregion'] , 'tsuh.region_c = rn.region_c')
                ->leftJoin(['td' => 'tbldivision'] , 'tsuh.division_c = td.DIVISION_C')
                ->leftJoin(['ts' => 'tblsection'] , 'tsuh.section_c = ts.SECTION_C')
                ->leftJoin(['tp' => 'tblprovince'] , 'tsuh.province_c = tp.province_c')
                ->leftJoin(['tcm' => 'tblcitymun'] , 'tsuh.citymun_c = tcm.citymun_c')
                ->leftJoin(['hgii' => 'hris_i_gov_issued_id'] , 'ui.id = hgii.hris_i_personal_info_id')
                ->where(['in', 'tsuh.office_c', [1,2,3,4]])
                ->andWhere(['tsuh.isdilg' => 1, 'tsuh.ispresent' => 1])
                ->andWhere(New Expression('hgii.agency IS NOT NULL'))
                ->andWhere(New Expression('hgii.agency != ""'))
                ->andWhere(New Expression('hgii.agency != "N/A"'.(empty($roQuery) || $roQuery == '' ? '' : ') AND ('.$roQuery).''))
                ->groupBy(['huser.hris_i_personal_info_id'])
                ->orderBy(['rn.region_m' => SORT_ASC, 'tsuh.inclusivedates_from' =>SORT_DESC])
                ->distinct()
                ->all();
        }
        else{
            $roemployeeList = null;
        }
        $arr = [];
        if(!empty($coemployeeList)){
            foreach ($coemployeeList as $qryData) {
                $arr[] = ['id' => $qryData['userid'],'text' => 'CENTRAL: '.$qryData['fullNames']];
            }
            // $arr['text'] = ['CENTRAL','children' => $arr];
        }
        if(!empty($roemployeeList)){
            foreach ($roemployeeList as $qryData) {
                $arr[] = ['id' => $qryData['userid'],'text' => 'REGIONAL: '.$qryData['fullNames']];
            }
            // $arr = ['text' => 'REGIONAL','children' => $text];
        }
        // $arr['pagination']['more'] = true;

        if(!empty(Yii::$app->request->get('id'))){
            $session->close();
        }
        else{
            \Yii::$app->response->format = 'json';
        }

        
        return $arr;

    }

    /**
     * Creates a new Awards model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Awards();
        $type = ArrayHelper::map(AttendanceType::find()->where(['attms_type_parent_id' => 1])->all(), 'id','description');

        if ($model->load(Yii::$app->request->post())) {
            $model->date = date('Y-m-d', strtotime($model->date));
            $model->save();
            \Yii::$app->getSession()->setFlash('success', 'Successfully added. ');
            return $this->redirect(['index']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'type' => $type,
        ]);
    }

    /**
     * Updates an existing Awards model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->date = date('M d, Y', strtotime($model->date));
        $type = ArrayHelper::map(AttendanceType::find()->where(['attms_type_parent_id' => 1])->all(), 'id','description');

        if ($model->load(Yii::$app->request->post())) {
            $model->date = date('Y-m-d', strtotime($model->date));
            $model->save();
            \Yii::$app->getSession()->setFlash('success', 'Successfully updated. ');
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'type' => $type,
        ]);
    }

    /**
     * Deletes an existing Awards model.
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
     * Finds the Awards model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Awards the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Awards::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
