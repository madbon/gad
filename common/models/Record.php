<?php

namespace common\models;

use Yii;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;
use niksko12\user\models\Barangay;
use niksko12\user\models\UserInfo;
use common\modules\cms\models\Status;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
// use common\modules\bops\models\OfficialsProfile;
// use common\modules\bops\models\Term;
/**
 * This is the model class for table "da_barangay".
 *
 * @property integer $id
 * @property string $region_c
 * @property string $province_c
 * @property string $citymun_c
 * @property string $barangay_c
 *
 * @property Tblregion $regionC
 * @property Tblprovince $provinceC
 */
class Record extends \yii\db\ActiveRecord
{

    public $new_citymun_c;
    public $new_brgy_c;
    public $location1;
    public $verifyCode;
    public $imageFile;
    public $dateRangeStart;
    public $dateRangeEnd;
    public $app_type;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bpls_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules =  [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, bmp, pdf'],
            [['form_type'], 'required'],
            [['dateRangeStart','dateRangeEnd','app_type'], Yii::$app->controller->action->id == 'index' ? 'required' : 'safe'],
            [['application_date'], Yii::$app->user->can('bpls_answer_monitoring_form') ? 'safe' : 'required'],
            [['quarter', 'year'], Yii::$app->user->can('bpls_answer_monitoring_form') && !Yii::$app->controller->action->id == 'index' ? 'required' : 'safe'],    
            [['citymun_c'], $this->userCitymun == '' || empty($this->userCitymun) || !Yii::$app->user->can('bpls_answer_monitoring_form') ? 'required' : 'safe'],
            [['citymun_c'], $this->userCitymun == '' || empty($this->userCitymun) || Yii::$app->user->can('bpls_admin_monitoring_form') ? 'required' : 'safe'],
            [['province_c'], empty($this->user->province) || Yii::$app->user->can('bpls_admin_monitoring_form') ? 'required' : 'safe'],
            [['region_c'], empty($this->user->region) || Yii::$app->user->can('bpls_admin_monitoring_form') ? 'required' : 'safe'],
            [['region_c', 'province_c', 'citymun_c'], 'string'],
            [['barangay_c'], 'string', 'max' => 3],
            [['first_name', 'middle_name', 'last_name', 'application_no', 'contact_no', 'email_address', 'hash'], 'string'],
            [['application_no','business_name','tin'], !Yii::$app->user->can('bpls_answer_monitoring_form') ? 'required' : 'safe'],
            [['bp_status_id','is_valid','form_file'], 'safe'],
            [['new_citymun_c', 'new_brgy_c', 'business_name', 'tin'], 'string'],
            [['email_address'], 'email'],
            [['region_c'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_c' => 'region_c']],
            [['province_c'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_c' => 'province_c']],
            [['application_type'], 'required', 'when' => function($model){
                return $model->form_type == '18';
            }, 'whenClient' => 'function(attribute, value){
                return $("#record-form_type").val() == "18";
            }'],
        ];
        
        return !Yii::$app->user->can('bpls_answer_monitoring_form') && Yii::$app->controller->action->id == 'create' ? Arrayhelper::merge($rules, $this->captcharule()) : $rules;
    }
    
    public function upload()
    {
        if ($this->validate() && !empty($this->imageFile)) {
            $this->imageFile->saveAs('uploads/forms/'.md5(Yii::$app->user->identity->id.date('mdY').$this->imageFile->baseName.$this->imageFile->extension).'.'.$this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function captcharule(){
        return [
            ['verifyCode', 'captcha', 'captchaAction' => 'rms/dynamic-view/captcha']];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => 'File Attachment:',   
            'id' => 'ID',
            'region_c' => 'Region',
            'province_c' => 'Province',
            'citymun_c' => 'City/Municipality',
            'barangay_c' => 'Barangay',
            'regionName' => 'Region',
            'regionNameShort' => 'Region',
            'provinceName' => 'Province',
            'citymunName' => 'City/Municipality',
            'barangayName' => 'Barangay',
            'year' => 'Year',
            'pbName' => 'Punong Barangay',
            'new_citymun_c' => 'New CityMun',
            'new_brgy_c' => 'New Barangay',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'application_no' => 'Permit No.',
            'application_date' => 'Application Date',
            'contact_no' => 'Contact Number',
            'email_address' => 'Email Address',
            'form_type' => 'Application Type',
            'application_type' => 'Application Type',
            'formTypeTitle' => 'Application Type',
            'user_id' => 'User ID',
            'bp_status_id' => 'Status',
            'tin' => 'DTI/SEC/CDA No.',
            'form_file' => 'Attachment',
            'form_file_extension' => 'Extension Name',
            'dateRangeStart' => 'Start Date',
            'dateRangeEnd' => 'End Date',
            'app_type' => 'Survey Type',
            'business_name' => "Owner's Name / Company Name",
        ];
    }


   public function afterFind(){
        parent::afterFind();

        // Replace value from database to declared variable
        $this->new_citymun_c = $this->citymun_c;
        $this->new_brgy_c = $this->barangay_c;


    }
    public function getUser()
    {
        $userinfo = UserInfo::findOne(['user_id' => !empty(Yii::$app->user->identity->userinfo) ? Yii::$app->user->identity->userinfo : 0]);
        return $userinfo;
    }

    public function getStatusName()
    {
        return $this->hasOne(Status::className(), ['id' => 'bp_status_id']);
    }

    public function getUserCitymun()
    {
        $user = !empty(Yii::$app->user->identity->userinfo) ? Yii::$app->user->identity->userinfo : 0;
        if(!empty(Yii::$app->user->identity->userinfo)){
            $userinfo = Citymun::findOne(['citymun_c' => $this->user->CITYMUN_C, 'region_c' => $this->user->REGION_C, 'province_c' => $this->user->PROVINCE_C]);
            return $userinfo == '' || empty($userinfo) ? '' : $userinfo;
        }
    }


    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['region_c' => 'region_c']);
    }

    // get region name 
    public function getRegionName()
    {
        return $this->region ? $this->region->region_m : "" ;
    }

    // get abbreviation of region name
    public function getRegionNameShort()
    {  
        return $this->region ? $this->region->region_m : "" ;
    }

    // relation with province - @return \yii\db\ActiveQuery
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['province_c' => 'province_c']);
    }

    // get province name 
    public function getProvinceName()
    {   
        return $this->province ? $this->province->province_m : "" ;
    }

    // relation with citymun - @return \yii\db\ActiveQuery
    public function getCitymun()
    {
        if($this->region_c == 13 && $this->province_c == 39){
            $qry = $this->hasOne(Citymun::className(), ['region_c'=>'region_c','province_c' => 'province_c']);
        } else {
            $qry = $this->hasOne(Citymun::className(), ['province_c' => 'province_c','citymun_c'=>'citymun_c']);
        }
        return $qry;
    }

    // get citymun name 
    public function getCitymunName()
    {   
       $CityMun = $this->region_c == 13 && $this->province_c == 39 ? "MANILA" : Citymun::findOne(['province_c' => $this->province_c,'citymun_c'=> $this->citymun_c]);
        return !empty($CityMun->citymun_m) ? $CityMun->citymun_m : '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangay()
    {
        // Override citymun '00' to new_citymun_c value, to avoid non property object because there's no 00 citymun_c value in tblbarangay;
        return $this->hasOne(Barangay::className(), ['province_c' => 'province_c', 'citymun_c' => 'new_citymun_c', 'barangay_c' => 'barangay_c']);
    }

    // get barangay name 
    public function getBarangayName()
    {
        return $this->barangay ? $this->barangay->barangay_m : "" ;
    }


    public function getFullName(){
        if(Yii::$app->user->identity->id == $this->user_id){
            return $this->first_name." ".$this->middle_name." ".$this->last_name;
        }
        else{
            return 'Public';
        }
        
    }

    public function getApplicationDate(){
        return date('F j, Y',strtotime($this->application_date));
    }

    public function getFormType(){
        return $this->hasOne(Category::className(), ['id' => 'form_type']);
    }

    public function getFormTypeTitle(){
        return !empty($this->formType->title) ? $this->formType->title : null;
    }

    public function getLguName(){
        return $this->provinceName.", ".$this->citymunName;
    }
}
