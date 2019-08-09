<?php

use yii\helpers\Html;
use \common\modules\report\controllers\DefaultController;
/* @var $this yii\web\View */
/* @var $model common\models\GadRecord */

$this->title = 'Annual GAD Accomplishment Report';
// $this->params['breadcrumbs'][] = ['label' => 'Step 1. Primary Information', 'url' => ['gad-record/create', 'ruc' => $ruc,'onstep' => $onstep], ['class' => 'btn btn-success']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<style>
	
</style>
<div class="gad-record-create">
<?php if(Yii::$app->user->can("gad_lgu_province_permission")){ ?>
    <ul class="nav nav-tabs">
            <?php if($qryReportStatus == 9) // if report status is under encoding tab
                {
                    echo $this->render('/common_tools/tabs/tab_input',[
                        'tabTitle' => 'Primary Information',
                        'liClass' => '',
                        'ruc' => $ruc,
                        'onstep' => $onstep,
                        'tocreate' => $tocreate,
                        'linkClass' => '',
                        'url' => '/report/gad-record/create'
                    ]);
                    echo $this->render('/common_tools/tabs/tab_encode',[
                        'tabTitle' => 'GAD Accomplishment Report FY '.DefaultController::GetPlanYear($ruc),
                        'liClass' => 'active',
                        'ruc' => $ruc,
                        'onstep' => $onstep,
                        'tocreate' => $tocreate,
                        'linkClass' => '',
                        'url' => 'index'
                    ]);
                }
            ?>
<?php }else if(Yii::$app->user->can("gad_lgu_permission")){ ?>

    <?php  if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS"){ // id HUC ?>
        <ul class="nav nav-tabs">
            <?php if($qryReportStatus == 8 ) // if report status is under encoding tab
                {
                    echo $this->render('/common_tools/tabs/tab_input',[
                        'tabTitle' => 'Primary Information',
                        'liClass' => '',
                        'ruc' => $ruc,
                        'onstep' => $onstep,
                        'tocreate' => $tocreate,
                        'linkClass' => '',
                        'url' => '/report/gad-record/create'
                    ]);
                    echo $this->render('/common_tools/tabs/tab_encode',[
                        'tabTitle' => 'GAD Accomplishment Report FY '.DefaultController::GetPlanYear($ruc),
                        'liClass' => 'active',
                        'ruc' => $ruc,
                        'onstep' => $onstep,
                        'tocreate' => $tocreate,
                        'linkClass' => '',
                        'url' => 'index'
                    ]);
                }
            ?>

    <?php }else{ // else non HUC -/////////////////////////////////////////////////// ?>   
        <ul class="nav nav-tabs">
            <?php if($qryReportStatus == 0) // if report status is under encoding tab
                {
                    echo $this->render('/common_tools/tabs/tab_input',[
                        'tabTitle' => 'Primary Information',
                        'liClass' => '',
                        'ruc' => $ruc,
                        'onstep' => $onstep,
                        'tocreate' => $tocreate,
                        'linkClass' => '',
                        'url' => '/report/gad-record/create'
                    ]);
                    echo $this->render('/common_tools/tabs/tab_encode',[
                        'tabTitle' => 'GAD Accomplishment Report FY '.DefaultController::GetPlanYear($ruc),
                        'liClass' => 'active',
                        'ruc' => $ruc,
                        'onstep' => $onstep,
                        'tocreate' => $tocreate,
                        'linkClass' => '',
                        'url' => 'index'
                    ]);
                }
            ?>
    <?php } ?>
<?php } // end of if gad field ?>
<div style="margin-bottom: 42px;"></div>
    
    <?= $this->render('index', [
        'select_GadFocused' => $select_GadFocused,
        'select_GadInnerCategory' => $select_GadInnerCategory,
        'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
        'dataRecord' => $dataRecord,
        'dataAR' => $dataAR,
        'recRegion' => $recRegion,
        'recProvince' => $recProvince,
        'recCitymun' => $recCitymun,
        'recTotalGadBudget' => $recTotalGadBudget,
        'recTotalLguBudget' => $recTotalLguBudget,
        'ruc' => $ruc,
        'onstep' => $onstep,
        'tocreate' => $tocreate,
        'dataAttributedProgram' => $dataAttributedProgram,
        'grand_total_ar' => $grand_total_ar,
        'fivePercentTotalLguBudget' => $fivePercentTotalLguBudget,
        'qryReportStatus' => $qryReportStatus,
        'select_ActivityCategory' => $select_ActivityCategory,
        'select_Checklist' => $select_Checklist,
        'select_scoreType' => $select_scoreType,
    ]) ?>

</div>
