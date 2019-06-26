<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\drugaffectation\models\DrugAffectationBarangay */

$this->title = 'Add LGU Information';
// $this->params['breadcrumbs'][] = ['label' => 'List of LGU Information Forms', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">    
    #headerIcon {
        font-size: 30px;
        margin-top: -5px;
    }
    .glyphicon-user{
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
    div.landing-page
    {
       /* width: 100%;
        margin-left: 25%;
        margin-right: auto;*/
        margin-top: 100px;
    }
    div.landing-page a
    {
        width: 100%;
        text-align: left;
        white-space: pre-line;
        /*margin-bottom: 5px;*/
        padding:10px;
        margin:5px;
        font-size: 15px;
    }
</style>

<div class="survey-basic-info-form-create">
    <?php
        // print_r($showLandingPage); exit;
    ?>

    <!-- <h3><b>&nbsp;&nbsp;Basic Information</b></h3> -->
    <?php if($showLandingPage == "no" || Yii::$app->user->can("bpls_answer_monitoring_form")) { ?>
        <center>
        <div class="steps-form-2" style="margin: 50px 0 50px 0;">
            <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
                <div class="steps-step-2">
                    <a href="#step-1" type="button" class="btn btn-circle-2-1 waves-effect ml-0 btn-blue-grey btn-amber" data-toggle="tooltip" data-placement="top" title="" data-original-title="Basic Information">
                        <i class="glyphicon glyphicon-user" aria-hidden="true" id="headerIcon"></i></a>
                </div>
                <div class="steps-step-2">
                    <a href="#step-2" id="step2btn" type="button" class="btn btn-blue-grey btn-circle-2 waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Personal Data">
                        <i class="glyphicon glyphicon-pencil aria-hidden="true" id="headerIcon"></i></a>
                </div>
                <div class="steps-step-2">
                    <a href="#step-3" type="button" class="btn btn-blue-grey btn-circle-2 waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Terms and Conditions">
                        <i class="glyphicon glyphicon-ok" aria-hidden="true" id="headerIcon"></i></a>
                </div>
            </div>
        </div>
        </center>
        <div class="box-body">     
            <?= $this->render('_form', [
                'model' => $model,
                'regions' => $regions,
                'provinces' => $provinces,
                'citymuns' => $citymuns,
                'barangays' => $barangays,
                'categories' => $categories,
            ]) ?>
        </div>
    <?php }else{ ?>
        <div class="landing-page"> 
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('NATIONAL CAPITAL REGION - NCR <span class="glyphicon glyphicon-play pull-right"></span>', ['/ncr'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('REGION I - ILOCOS REGION <span class="glyphicon glyphicon-play pull-right"></span>', ['/ilocos'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('REGION II - CAGAYAN VALLEY <span class="glyphicon glyphicon-play pull-right"></span>', ['/cagayan'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('REGION III - CENTRAL LUZON <span class="glyphicon glyphicon-play pull-right"></span>', ['/central-luzon'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('REGION IV-A - CALABARZON <span class="glyphicon glyphicon-play pull-right"></span>', ['/calabarzon'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('MIMAROPA <span class="glyphicon glyphicon-play pull-right"></span>', ['/mimaropa'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('REGION V - BICOL REGION <span class="glyphicon glyphicon-play pull-right"></span>', ['/bicol'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('REGION VI - WESTERN VISAYAS <span class="glyphicon glyphicon-play pull-right"></span>', ['/western-visayas'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('REGION VII - CENTRAL VISAYAS <span class="glyphicon glyphicon-play pull-right"></span>', ['/central-visayas'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('REGION VIII - EASTERN VISAYAS <span class="glyphicon glyphicon-play pull-right"></span>', ['/eastern-visayas'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('REGION IX - ZAMBOANGA PENINSULA <span class="glyphicon glyphicon-play pull-right"></span>', ['/zamboanga'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('REGION X - NORTHERN MINDANAO <span class="glyphicon glyphicon-play pull-right"></span>', ['/northern-mindanao'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('REGION XI - DAVAO REGION <span class="glyphicon glyphicon-play pull-right"></span>', ['/davao'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('REGION XII - SOCCSSARGEN <span class="glyphicon glyphicon-play pull-right"></span>', ['/soccssargen'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('CORDILLERA ADMINISTRATIVE REGION - CAR <span class="glyphicon glyphicon-play pull-right"></span>', ['/car'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= Html::a('REGION XIII - CARAGA <span class="glyphicon glyphicon-play pull-right"></span>', ['/caraga'], ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
            </div>    
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

        </div>
    <?php } ?>
</div>

<?php
    $this->registerJs('
        $( "#step2btn" ).click(function() {
            $( ".btn" ).trigger( "click" );
        });
    ')
?>