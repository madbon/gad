<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\bootstrap\Carousel;
use yii\helpers\Url; 
use miloschuman\highcharts\Highcharts;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
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

/* @var $this yii\web\View */
/* @var $model common\modules\drugaffectation\models\DrugAffectationBarangay */

$this->title = 'Thank You';
// $this->params['breadcrumbs'][] = ['label' => 'List of LGU Information Forms', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<style>
.th-title{
    background:#f7f7f7;
}
#headerIcon {
    font-size: 30px;
    margin-top: -5px;
}
.glyphicon-ok{
    color: white;
}
.btn-circle-2-1 {
    width: 70px;
    height: 70px;
    border: 2px solid #59698D;
    background-color: #59698D !important;
    color: #59698D !important;
    border-radius: 50%;
    padding: 22px 18px 15px 18px;
    margin-top: -22px;
}
</style>
<div class="drug-affectation-barangay-view">

    <center>
    <div class="steps-form-2" style="margin: 50px 0 50px 0;">
        <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
            <div class="steps-step-2">
                <a href="#step-1" type="button" class="btn btn-circle-2 waves-effect ml-0 btn-blue-grey btn-amber" data-toggle="tooltip" data-placement="top" title="" data-original-title="Basic Information">
                    <i class="glyphicon glyphicon-user" aria-hidden="true" id="headerIcon"></i></a>
            </div>
            <div class="steps-step-2">
                <a href="#step-2" id="step2btn" type="button" class="btn btn-blue-grey btn-circle-2 waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Personal Data">
                    <i class="glyphicon glyphicon-pencil aria-hidden="true" id="headerIcon"></i></a>
            </div>
            <div class="steps-step-2">
                <a href="#step-3" type="button" class="btn btn-blue-grey btn-circle-2-1 waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Terms and Conditions">
                    <i class="glyphicon glyphicon-ok" aria-hidden="true" id="headerIcon"></i></a>
            </div>
        </div>
    </div>
    </center>

    <div class="row">
        <div class="col-md-12">  
            <div class="box box-primary">   
                <?php if(Yii::$app->user->isGuest){ ?>
                <div class="jumbotron">
                    <h1 style="font-family: Lucida Console, Monaco, monospace">THANK YOU!</h1><br> 
                    <span><i class="glyphicon glyphicon-ok" style="color: green;font-size: 80px;"></i></span>
                    <h3>You have successfully completed our online survey. You may now close this tab.</h3>
                </div>
                <?php } ?>
                <div class="jumbotron">
                    <div class="box box-default">
                        <div class="box-header pull-left">Summary</div>
                        <table class="table table-responsive table-bordered" style="font-size:13px;text-align: left">

                            <?php $cat = "";  
                            foreach($data as $d){ ?>
                                <?php if($cat != $d->category_title) { ?>
                                    <tr style="background:#3c8dbc;color: white;border-left:2px solid #3c8dbc;">
                                        <th colspan="2" style="text-align:left;"><?= $d->category_title; ?></th>
                                    </tr>
                                <?php } ?>
                            <?php 
                                if($d->type_title == "title") { ?>
                                <tr>
                                    <th colspan=2 style="background:#dedddd;border-left:2px solid #827e7e;"><?= $d->indicator_title; ?></th>
                                </tr>
                                <?php } else if($d->type_title == "second-level-title") { ?>
                                <tr>
                                    <th colspan=2 style="background:#e4e4e4;"><?= $d->indicator_title; ?></th>
                                </tr>
                                <?php } else if($d->type_title == "third-level-title") { ?>
                                <tr>
                                    <th colspan=2 style="background:#fff;"><?= $d->indicator_title; ?></th>
                                </tr>
                                <?php } else { ?>
                                <tr>
                                    <td style="padding-left:20px;"><?= $d->indicator_title; ?></td>
                                    <td style="text-align: center;background-color: #3c8dbc;color:white;">
                                        <?php if($d->unit_title != 'FILE ATTACHMENT'){ ?>
                                            <?php if($d->unit_title == 'CHECKBOX'){ ?>
                                                <?= $d->value == 1 ? '<i class="glyphicon glyphicon-ok"></i>' : '<i class="glyphicon glyphicon-remove"></i>'; ?>
                                            <?php } else if($d->unit_title == 'AMOUNT'){ ?>
                                                <?= 'Php '.number_format(!empty($d->value) ? $d->value : 0, 2); ?>
                                            <?php } else{ ?>
                                                <?= $model->formType->lgup_content_type_id == 10 || $model->formType->lgup_content_type_id == 9 ? "Data" : $d->value; ?>
                                            <?php } ?>
                                        <?php } else{ ?>
                                            <?= Html::a('View attachment/s', ['viewattachments','id' => $d->value,'title' => $model->citymunName, 'id2' => $model->id, 'cat' => $model->form_type], ['class' => 'btn btn-xs btn-primary']) ?>
                                        <?php } ?>           
                                            <?php if($d->subs){ ?>
                                                <?php foreach ($data2 as $sub) {
                                                    if($sub->indicator_id == $d->indicator_id){ 
                                                        if($d->ans == $d->value) { ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-left:34px;">
                                        <i class="glyphicon glyphicon-arrow-right"></i><?= $model->formType->lgup_content_type_id == 10  || $model->formType->lgup_content_type_id == 9 ? $d->value : "" ?> <?= $sub->sub_question; ?>
                                    </td>
                                    <td style="text-align: center;color:black;">
                                        <?php if($sub->type == 10){ ?>
                                            <?= Html::a('View attachment/s', ['viewattachments','id' => $sub->value,'title' => $model->citymunName, 'id2' => $model->id, 'cat' => $model->form_type], ['class' => 'btn btn-xs btn-primary']) ?>
                                        <?php }else { ?>
                                            <?= $sub->value ? $sub->value : "" ; ?>
                                                <?php  } }
                                                    }
                                                } ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php }
                                $cat = $d->category_title;
                            } ?>
                        </table>
                    </div>
                </div>
                 <?php if($session['canUpdate']){ ?>
                    <div>
                        <div class="btn-group pull-left">
                            <?= Html::a('<span class="glyphicon glyphicon-triangle-left" style="font-size:12px;"></span> Edit', ["update", 'id' => $id, 'cat' => $activeCategory, 'uid' => $model->hash], ['class' => 'btn btn-info']) ?>
                        </div>
                        
                        <div class="btn-group pull-right">
                            <?php /*echo Html::a('Submit <span class="glyphicon glyphicon-triangle-right" style="font-size:12px;"></span>', 
                                        [
                                            "view", 'id' => $id, 'cat' => $activeCategory
                                        ], 
                                        [
                                            'class' => 'btn btn-success',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to submit this survey?',
                                                'method' => 'post'
                                            ]
                                        ])*/ ?>
                        </div>
                    </div>
                <?php } ?>
            </div>            
            <?php                         
              if(Yii::$app->user->can('bpls_answer_monitoring_form') && $model->bp_status_id == 1 && $model->user_id == Yii::$app->user->identity->id){
                echo Html::a('<span class="glyphicon glyphicon-ok"></span> Save as final', ['save-as-final','id'=>$model->id, 'uid' => $model->hash], 
                      ['class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip' , 'title' => 'Save as final', 'style' => 'font-size:15px;padding: 10px 14px;',
                       'data' => ['confirm' => 'Are you sure you want to save this form as final?','method' => 'post']
                      ]).'<hr>';
              }
            ?>
        </div>
    </div>
</div>