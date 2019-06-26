<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\typeahead\Typeahead;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\Size;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;
use kartik\date\DatePicker;
use common\modules\oms\controllers\ValidateReportHistoryController;


/* @var $this yii\web\View */
/* @var $searchModel common\modules\drugaffectation\models\DrugAffectationBarangaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Survey Forms';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
  .glyphicon-lg{font-size:3em}
  .blockquote-box{border-right:5px solid #E6E6E6; border-top: 1px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; border-left: 1px solid #E6E6E6; margin-bottom:25px; border-style: solid;}
  .blockquote-box .square{width:100px;min-height:80px;margin-right:22px;text-align:center!important;background-color:#E6E6E6;padding:20px 0}
  .blockquote-box.blockquote-info{border-color:#46B8DA}
  .blockquote-box.blockquote-info .square{background-color:#5BC0DE;color:#FFF}
</style>
<div class="drug-affectation-barangay-index">
    <div class="row">
      <div class="col-md-12">
        <!-- <h3 class=""><strong>Survey Forms</strong></h3> -->
        <div class="box box-primary">          
          <div class="box-header" style="margin-bottom: -15px">
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="row">   
              <div class="col-md-12">   
                <div class="row">   
                  <p style="margin-left: 14px;font-size: 16px;"><strong>Search</strong></p> 
                  <div class="col-md-12">     
                    <hr style="border: 1px solid #d2d6de;margin-top: -3px;">   
                  </div>     
                  <?= $this->render('_search', ['model' => $searchModel,
                      'regions' => $regions,
                      'provinces' => $provinces,
                      'citymuns' => $citymuns,
                      'categories' => $categories,
                  ]); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>      
      <div class="col-md-12">   
        <div class="box box-primary">
          <div class="box-body">
            <div class="row">   
              <p style="margin-left: 14px;font-size: 16px;"><strong>Forms</strong></p> 
              <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Answer Monitoring Form', ['create'], ['class' => 'btn btn-flat btn-success btn-sm pull-right', 'style' => 'margin-top:-38px;margin-right:15px;']) ?>

             <?php
              Modal::begin([
                  'header'=>'Export survey to excel',
                  'size' => 'modal-lg',
                  'toggleButton' => [
                      'label'=>'<span class="glyphicon glyphicon-download-alt"></span> Download Survey', 'class'=>'btn btn-flat btn-info btn-sm pull-right', 'style' => 'margin-top:-38px;margin-right:370px;',
                  ],
              ]);
              ?>            
                <?php $form = ActiveForm::begin() ?> 
<?php 
                                    // echo '<label class="control-label" for="lasvldates-[{$index}]-from_date">Start Date</label>';
$layout3 = <<< HTML
    <span class="input-group-addon">From</span>
    {input1}
    <span class="input-group-addon">To</span>
    {input2}
HTML;
                    echo $form->field($model, 'app_type')->dropDownList(['1' => 'New Application (Business Permit)', '2' => 'Renewal (Business Permit)'],['prompt'=>'Select Survey Type...'])->label('Survey Type <span style="color:red;font-size:18px;">*</span>'); 
                    echo '<label class="control-label" for="record-daterangestart">Date Range <span style="color:red;font-size:18px;">*</span></span></label>';
                    echo DatePicker::widget([
                        'model' => $model,
                        'attribute' => "dateRangeStart",
                        'attribute2' => "dateRangeEnd",
                        'options' => [
                                'class' => 'picker','placeholder' => 'Start date',
                        ],
                        'options2' => [
                                'class' => 'picker','placeholder' => 'End date',
                        ],
                        'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                        'layout' => $layout3,
                        'type' => DatePicker::TYPE_RANGE,
                        'form' => $form,
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                            'minViewMode' => 'days',
                            'viewmode' => 'months',
                        ]
                    ]);
                    ?>
                  <br>
                  <hr style="border: 1px solid #d2d6de;margin-top: 10px;">
                    <div class="form-group">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-download-alt"></span> Download', ['class' => 'btn btn-success pull-right']) ?>
                    </div>
                  <br><br>
                <?php ActiveForm::end(); ?>
              <?php Modal::end(); ?>
              <?php if(Yii::$app->user->can('bpls_add_registered_business')){ ?>
              <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Add Registered Business', ['registered-business'], ['class' => 'btn btn-flat btn-primary btn-sm pull-right', 'style' => 'margin-top:-38px;margin-right:190px;']) ?>
              <?php } ?>
              <div class="col-md-12">     
                <hr style="border: 1px solid #d2d6de;margin-top: -3px;">   
              </div> 
              <div class="col-md-12">
              <div class="col-md-12 table-responsive">
                <strong>Actions: </strong>
                  <span class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></span> View
                  <span class="btn btn-info btn-xs"><span class="glyphicon glyphicon-pencil"></span></span> Update
                  <span class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></span> Cancel
                  <span class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-file"></span></span> Uploaded Form  
                  <span class="btn btn-default btn-xs"><span class="glyphicon glyphicon-file"></span></span> Upload Form  
                <br>
                <br>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-responsive table-hover table-condensed table-bordered'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                          'attribute' => 'fullName',
                          'label' => 'Submitted by',
                        ],
                        [
                          'attribute' => 'date_added',
                          'label' => 'Date Encoded',
                          'enableSorting' => false,
                          // 'value' => 'date',
                        ],
                        // 'attribute' => 'provinceName',
                        [
                          'attribute' => 'citymunName',
                          'value' => function ($model){
                              if($model->region_c =='13' && $model->province_c == '39'){
                                $model->citymun_c = '00';
                                return 'CITY OF MANILA';
                              }else{
                                return $model->citymunName;
                              }
                          }
                        ],
                        'formTypeTitle',
                        [
                          'format' => 'raw',
                          'attribute' => 'is_valid',
                          'label' => 'Status',
                          'value' => function ($model){
                              return ValidateReportHistoryController::validationDisplay($model->is_valid);
                          }
                        ],
                        [
                          'attribute' => 'quarter',
                          'value' => function($model){
                              if($model->quarter == 1){ return '1st'; }
                              else if($model->quarter == 2){ return '2nd'; }
                              else if($model->quarter == 3){ return '3rd'; }
                              else if($model->quarter == 4){ return '4th'; }
                              else{ return null; }
                          },
                          'enableSorting' => false
                        ],
                        [
                          'attribute' => 'year',
                          'enableSorting' => false
                        ],
                        [
                            'format' => 'raw',
                            // 'noWrap' => true,
                            'attribute' => 'Action',
                            'label' => 'Action',
                            'value'=> function($data){  
                                if($data->user_id == Yii::$app->user->identity->id){
                                  if(!empty($data->form_file) || $data->form_file != ''){
                                    $frmfile = Html::a('<span class="glyphicon glyphicon-file"></span>', ['form-file','id'=>$data->id, 'uid' => $data->hash], ['class' => 'modalButton btn btn-xs btn-warning btn-xs', 'data-toggle' => 'tooltip' , 'title' => 'Uploaded Form']);
                                  }
                                  else{
                                    $frmfile = Html::a('<span class="glyphicon glyphicon-file"></span>', ['form-file','id'=>$data->id, 'uid' => $data->hash], ['class' => 'modalButton btn btn-xs btn-default btn-xs', 'data-toggle' => 'tooltip' , 'title' => 'Upload Form']);
                                  }
                                  if($data->bp_status_id == 1){
                                    $saf = Html::a('<span class="glyphicon glyphicon-ok"></span>', ['save-as-final','id'=>$data->id, 'uid' => $data->hash], 
                                          ['class' => 'btn btn-xs btn-success btn-xs', 'data-toggle' => 'tooltip' , 'title' => 'Save as final',
                                           'data' => ['confirm' => 'Are you sure you want to save this form as final?','method' => 'post']
                                          ]);
                                  }
                                  else{
                                    $saf = null;
                                  }
                                }
                                else{
                                  $frmfile = null;
                                  $saf = null;
                                }
                                if($data->user_id != Yii::$app->user->identity->id && ($data->is_valid != 8 || $data->is_valid != 1)){
                                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view','id'=>$data->id, 'cat' => $data->form_type, 'uid' => $data->hash], ['class' => 'btn btn-xs btn-primary btn-xs', 'data-toggle' => 'tooltip' , 'title' => 'View']).'&nbsp;'.$frmfile;
                                }
                                else{
                                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view','id'=>$data->id, 'cat' => $data->form_type, 'uid' => $data->hash], ['class' => 'btn btn-xs btn-primary btn-xs', 'data-toggle' => 'tooltip' , 'title' => 'View']). '&nbsp;' 
                                  .Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update','id'=>$data->id, 'cat' => $data->form_type, 'uid' => $data->hash], ['class' => 'btn btn-xs btn-info btn-xs', 'data-toggle' => 'tooltip' , 'title' => 'Update']).'&nbsp;'
                                  .Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete','id'=>$data->id, 'cat' => $data->form_type], 
                                          ['class' => 'btn btn-xs btn-danger btn-xs', 'data-toggle' => 'tooltip' , 'title' => 'Cancel',
                                           'data' => ['confirm' => 'Are you sure you want to cancel this application?','method' => 'post']
                                          ]).'&nbsp;'.$frmfile.'&nbsp;'.$saf;
                                }
                            },
                            // 'contentOptions'=>['style'=>'width:500px;'],
                        ]
                    ],
                    'layout' => "{items}\n<div class='text-info text-right'>{summary}</div>\n{pager}",
                ]); ?>
              </div></div>
            </div>
          </div>  
        </div>
      </div>
    </div>  

  <div class="modal fade" id="modal2" role="dialog">
      <div class="modal-dialog ">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <!-- <h4>Add Barangay</h4> -->
              </div>
              <div class="modal-body">
                  <div  id='modalContents'></div>
                  
              </div>
          </div>
      </div>
  </div> 
</div>
