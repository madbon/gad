<?php

use yii\helpers\Html;
use kartik\grid\GridView;
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
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $searchModel common\modules\drugaffectation\models\DrugAffectationBarangaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Registered Business';
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
        <!-- <h3 class=""><strong>List of Registered Clients</strong></h3> -->
        <div class="box box-primary">          
          <div class="box-header" style="margin-bottom: -15px">
             <?php
              Modal::begin([
                  'header'=>'Upload Excel File',
                  'size' => 'modal-lg',
                  'toggleButton' => [
                      'label'=>'<i class="glyphicon glyphicon-upload"></i> Upload Excel', 'class'=>'btn btn-success btn-sm pull-right', 'style' => 'margin-top:-5px;',
                  ],
              ]);
              ?>
              <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                <?php echo $form->field($model, 'imageFile')->widget(FileInput::classname(), [

                    'pluginOptions' => [
                        'browseClass' => "btn btn-primary btn-file",
                        'showPreview' => true,
                        'showCaption' => true,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseLabel' => 'Browse',
                        'maxFileCount' => 1,
                        'allowedFileExtensions' => ["xlsx", "xls", "csv"],
                    ],
                    'options'=>[
                        'multiple'=>false,
                    ],
                ]); ?>
                <hr style="border: 1px solid #d2d6de;margin-top: 10px;">
                <button class="btn btn-sm btn-success pull-right"><i class="glyphicon glyphicon-upload"></i> Upload</button>
                <br><br>
              <?php ActiveForm::end(); ?>
              <?php Modal::end(); ?>
              <?= Html::a('<span class="glyphicon glyphicon-download"></span> Download Template', ['download-template'], ['class' => 'btn btn-flat btn-primary btn-sm pull-right', 'style' => 'margin-top:-5px;margin-right:5px;']) ?>
              <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Manual Encode', ['/rms/uploaded-client/create'], ['class' => 'btn btn-flat btn-info btn-sm pull-right', 'style' => 'margin-top:-5px;margin-right:5px;']) ?>
              <p style="font-size: 16px;"><strong>Registered Business:</strong></p>
            <hr style="border: 1px solid #d2d6de;margin-top: 10px;">
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="row">   
              <div class="col-md-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    // 'filterModel' => $searchModel,
                    'beforeHeader'=>[
                        [
                            'columns'=>[
                                ['content'=>"Business Owner's Info.", 'options'=>['colspan'=>2, 'style'=>'background-color:#3c8dbc;color:white;border: 1px solid #d2d6de;']], 
                                ['content'=>'Business Details', 'options'=>['colspan'=>5, 'style'=>'background-color:#3c8dbc;color:white;border: 1px solid #d2d6de;']], 
                            ],
                            'options'=>['class'=>'skip-export'] // remove this row from export
                        ]
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'business_name',
                        // 'first_name',
                        // 'last_name',
                        [
                          'attribute' => 'application_no',
                        ],
                        'application_date',
                        [
                          'attribute' => 'business_tin',
                          'label' => 'DTI/SEC/CDA No.'
                        ],       
                        [
                          'attribute' => 'business_type',
                          'value' => 'businessType.description'
                        ],
                        [
                          'class' => 'kartik\grid\ActionColumn',
                          'template' => '{view} {update} {delete}',
                          'buttons'=>[

                              'view'=>function ($url, $model) {
                                  return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', ['/rms/uploaded-client/view', 'id' => $model->id], 
                                    ['class' => 'btn btn-primary btn-xs', 'data-toggle' => 'tooltip' , 'title' => 'View']);
                              },
                              
                              'update'=>function ($url, $model) {
                                  return Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['/rms/uploaded-client/update', 'id' => $model->id], 
                                    ['class' => 'btn btn-primary btn-xs', 'id' => 'updateLAL', 'data-toggle' => 'tooltip' , 'title' => 'Update']);
                              },

                              'delete'=>function ($url, $model) {
                                  return Html::a('<i class="glyphicon glyphicon-remove"></i>', 
                                    [
                                      '/rms/uploaded-client/delete', 'id' => $model->id
                                    ], 
                                    [
                                      'class' => 'btn btn-danger btn-xs',
                                      'data-toggle' => 'tooltip' , 
                                      'title' => 'Delete',
                                      'data' => [
                                          'confirm' => 'Are you sure you want to delete this record?',
                                          'method' => 'post']
                                    ]);
                              }
                            ]
                        ],
                    ],
                ]); ?>
              </div>
            </div>
          </div>
        </div>
        <?php if(!empty($excelData)){ ?>
          <div class="box box-primary">          
            <div class="box-header" style="margin-bottom: -15px">
              <strong>Excel Data: (filename: <?= $excelFilename ?>)</strong>
              <hr style="border: 1px solid #d2d6de;margin-top: 10px;">   
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="row">   

                <div class="col-md-12">           
                  <div class="callout callout-info">
                    <h4><i class="fa fa-info-circle"></i> Note!</h4>
                      <ul>
                        <li>The uploaded excel will not be saved if the grid has <span class="label label-danger">Duplicate</span> legend and the row is highlighted in red background.</li> 
                      </ul>
                  </div>
                </div>
                <div class="col-md-12">
                  <table class="table table-responsive table-bordered">
                    <tr>
                          <th colspan='2' style='background-color:#3c8dbc;color:white;border: 1px solid #d2d6de;'>Business Owner (Full Name)</th>
                          <th colspan='4' style='background-color:#3c8dbc;color:white;border: 1px solid #d2d6de;'>Business Details</th>
                    </tr>
                    <tr>
                          <th>#</th>
                          <th>Business/Company Name</th>
                          <th>Permit No.</th>
                          <th>DTI/SEC/CDA No.</th>
                          <th>Date of registration</th>
                          <th>Type</th>
                    </tr>
                  <?php  
                    $rowCount = 1;
                    $wDuplicate = 0;
                    foreach ($excelData as $row) {
                      if($row[4] == 1){ $businesstype = 'Micro Business';}else if($row[4] == 2){ $businesstype = 'Small Business';}else if($row[4] == 3){ $businesstype = 'Medium Business';} else if($row[4] == 4){ $businesstype = 'Large Business';} else{ $businesstype = 'N/A';}
                      $result=array_diff($businessPermit,$row);
                      if(count($businessPermit) != count($result)){
                        $wDuplicate = 1;
                        echo '<tr class="danger">';
                      }
                      else{
                        echo '<tr>';
                      }                                         
                      echo "<td style='text-align:left;'>".$rowCount."</td>";
                      echo '<td>' . $row[0] . '</td>';
                      echo '<td>' . $row[1] . '</td>';
                      echo '<td>' . $row[2] . '</td>';

                      if(count($businessPermit) != count($result)){
                         echo '<td>' . $row[3] . ' <span class="label label-danger">Duplicate</span></td>';
                      }
                      else{
                        echo '<td>' . $row[3] . '</td>';
                      }                
                      echo '<td>' . $businesstype . '</td>';                       
                      $rowCount++;
                      echo '</tr>';
                    }
                  ?> 
                </table>
                <?php if($wDuplicate == 0){ ?>
                <?= Html::a('<span class="glyphicon glyphicon-save"></span> Save', ['save-excel-data'], 
                  ['class' => 'btn btn-sm btn-success pull-right',
                   'data' => ['confirm' => 'Are you sure you want to upload this data?','method' => 'post']
                ])?>
                <?php }?>
                </div>
              </div>
            </div>
          </div>
      <?php } ?>
      </div>   
    </div> 
</div>
